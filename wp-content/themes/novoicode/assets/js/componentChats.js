// Arquivo: wp-content/themes/novoicode/assets/js/componentChats.js
const { useState, useEffect, useRef } = React;

function MarkdownRenderer({ content }) {
    const ReactMarkdown = window.ReactMarkdown;
    if (ReactMarkdown) {
        return React.createElement(ReactMarkdown, {
            components: {
                a: (props) => {
                    return React.createElement('a', {
                        ...props,
                        target: '_blank',
                        rel: 'noopener noreferrer'
                    });
                }
            }
        }, content);
    }
    return React.createElement('div', null, content);
}

function ChatGPTSearch() {
    const [query, setQuery] = useState("");
    const [messages, setMessages] = useState([
        { role: "assistant", content: "**Bem-vindo à IA do ICODE**\n\n*faça uma pergunta ...*" }
    ]);
    const [conversationHistory, setConversationHistory] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [isStreaming, setIsStreaming] = useState(false);
    const [currentStreamId, setCurrentStreamId] = useState(null);
    const [ollamaModel, setOllamaModel] = useState("mistral");
    const [spinnerSrc, setSpinnerSrc] = useState("/wp-content/themes/novoicode/assets/img/logo2.png");

    const textareaRef = useRef(null);
    const messagesEndRef = useRef(null);
    const currentAssistantMessageRef = useRef(null);
    const streamControllerRef = useRef(null);

    // Rolar para a última mensagem
    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    useEffect(() => {
        scrollToBottom();
    }, [messages]);

    useEffect(() => {
        if (textareaRef.current) {
            textareaRef.current.focus();
        }
    }, []);

    // Focar no textarea quando o streaming terminar
    useEffect(() => {
        if (!isStreaming && !isLoading && textareaRef.current) {
            textareaRef.current.focus();
        }
    }, [isStreaming, isLoading]);

    // Cancelar stream se necessário
    useEffect(() => {
        return () => {
            if (streamControllerRef.current) {
                streamControllerRef.current.abort();
            }
        };
    }, []);

    const handleChange = (event) => {
        setQuery(event.target.value);
    };

    const handleModelChange = (event) => {
        setOllamaModel(event.target.value);
        // Manter sempre o mesmo spinner
        setSpinnerSrc("/wp-content/themes/novoicode/assets/img/logo2.png");
    };

    const handleSubmit = async (event) => {
        event.preventDefault();
        if (query.trim() === "") return;

        const userMessage = { role: "user", content: query };
        setMessages(prev => [...prev, userMessage]);
        setQuery("");
        setIsLoading(true);

        // Limpar mensagens de streaming anteriores
        currentAssistantMessageRef.current = null;

        try {
            // Atualizar histórico
            const updatedHistory = [...conversationHistory, userMessage];
            setConversationHistory(updatedHistory);

            // Criar mensagem de assistente vazia para streaming
            const streamId = Date.now().toString();
            setCurrentStreamId(streamId);
            setIsStreaming(true);
            setIsLoading(false); // Mudamos para streaming mode

            const assistantMessage = {
                role: "assistant",
                content: "",
                streamId: streamId,
                isStreaming: true
            };

            setMessages(prev => [...prev, assistantMessage]);

            // Fazer requisição de streaming
            await streamOllamaResponse(query, updatedHistory, streamId);
            
        } catch (error) {
            console.error("Erro ao chamar a API:", error);
            setMessages(prev => [...prev, {
                role: "assistant",
                content: "Ocorreu um erro ao processar a solicitação: " + error.message
            }]);
            setIsLoading(false);
            setIsStreaming(false);
            
            // Focar no textarea em caso de erro
            setTimeout(() => {
                if (textareaRef.current) {
                    textareaRef.current.focus();
                }
            }, 50);
        }
    };

    const streamOllamaResponse = async (userQuery, history, streamId) => {
        try {
            // Cancelar stream anterior se existir
            if (streamControllerRef.current) {
                streamControllerRef.current.abort();
            }

            // Criar novo AbortController para este stream
            const controller = new AbortController();
            streamControllerRef.current = controller;

            const response = await fetch('/chatollama', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    model: ollamaModel,
                    messages: [...history, { role: "user", content: userQuery }]
                }),
                signal: controller.signal
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const reader = response.body.getReader();
            const decoder = new TextDecoder();
            let fullResponse = "";
            let buffer = "";

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;

                buffer += decoder.decode(value, { stream: true });
                const lines = buffer.split('\n');

                // Processar todas as linhas exceto a última (que pode estar incompleta)
                for (let i = 0; i < lines.length - 1; i++) {
                    const line = lines[i].trim();
                    if (!line) continue;

                    try {
                        const data = JSON.parse(line);

                        if (data.type === 'chunk' && data.content) {
                            const chars = data.content.split('');

                            for (const char of chars) {
                                fullResponse += char;

                                setMessages(prev => prev.map(msg => {
                                    if (msg.streamId === streamId) {
                                        return {
                                            ...msg,
                                            content: fullResponse,
                                            isStreaming: true
                                        };
                                    }
                                    return msg;
                                }));

                                scrollToBottom();

                                await new Promise(r => setTimeout(r, 30)); //velocidade da digitação
                            }
                        }

                        if (data.type === 'error') {
                            throw new Error(data.content);
                        }

                        if (data.done) {
                            break;
                        }
                    } catch (e) {
                        console.error('Erro ao processar chunk:', e, line);
                    }
                }

                // Manter a última linha incompleta no buffer
                buffer = lines[lines.length - 1];
            }

            // Stream completo
            setConversationHistory(prev => [...prev, { role: "assistant", content: fullResponse }]);

            // Atualizar mensagem final removendo flag de streaming
            setMessages(prev => prev.map(msg => {
                if (msg.streamId === streamId) {
                    return {
                        ...msg,
                        isStreaming: false,
                        fontes: { posts: [], pdfs: [] } // Adicionar fontes vazias para consistência
                    };
                }
                return msg;
            }));

            // Focar no textarea após a conclusão
            setTimeout(() => {
                if (textareaRef.current) {
                    textareaRef.current.focus();
                }
            }, 50);

        } catch (error) {
            if (error.name === 'AbortError') {
                console.log('Streaming cancelado pelo usuário');
                setMessages(prev => prev.map(msg => {
                    if (msg.streamId === streamId) {
                        return {
                            ...msg,
                            content: msg.content + "\n\n*Resposta interrompida*",
                            isStreaming: false
                        };
                    }
                    return msg;
                }));
            } else {
                console.error('Erro no streaming:', error);
                setMessages(prev => [...prev, {
                    role: "assistant",
                    content: "Erro na resposta: " + error.message
                }]);
            }
            
            // Focar no textarea em caso de erro
            setTimeout(() => {
                if (textareaRef.current) {
                    textareaRef.current.focus();
                }
            }, 50);
            
        } finally {
            setIsStreaming(false);
            setCurrentStreamId(null);
            streamControllerRef.current = null;
        }
    };

    const cancelStream = () => {
        if (streamControllerRef.current) {
            streamControllerRef.current.abort();
            setIsStreaming(false);
            setCurrentStreamId(null);
            
            // Focar no textarea após cancelar
            setTimeout(() => {
                if (textareaRef.current) {
                    textareaRef.current.focus();
                }
            }, 50);
        }
    };

    const handleKeyDown = (event) => {
        if (event.key === "Enter" && !event.shiftKey) {
            event.preventDefault();
            handleSubmit(event);
        }
    };

    return (
        React.createElement('div', { className: 'chat-container' },
            React.createElement('div', { className: 'messages' },
                // Inverter a ordem das mensagens: mais recentes no final (perto do textarea)
                [...messages].reverse().map((msg, index) =>
                    React.createElement('div', {
                        key: messages.length - 1 - index,
                        ref: index === 0 ? messagesEndRef : null, // A última mensagem (mais recente) recebe o ref
                        className: `message ${msg.role === 'user' ? 'user-message' : 'assistant-message'} ${msg.isStreaming ? 'streaming-message' : ''}`
                    },
                        msg.role === 'assistant' && msg.isStreaming ? (
                            React.createElement('div', { className: 'streaming-container' },
                                React.createElement(MarkdownRenderer, { content: msg.content }),
                                React.createElement('div', { className: 'streaming-indicator' },
                                    React.createElement('span', { className: 'streaming-dot' }),
                                    React.createElement('span', { className: 'streaming-dot' }),
                                    React.createElement('span', { className: 'streaming-dot' })
                                )
                            )
                        ) : (
                            React.createElement(React.Fragment, null,
                                React.createElement(MarkdownRenderer, { content: msg.content }),
                                msg.role === 'assistant' && msg.fontes && (msg.fontes.posts.length > 0 || msg.fontes.pdfs.length > 0) &&
                                React.createElement('div', { className: 'fontes-container' },
                                    React.createElement('h5', null, 'Fontes Consultadas:'),
                                    React.createElement('ul', null,
                                        [
                                            ...msg.fontes.posts.map((fonte, idx) =>
                                                React.createElement('li', { key: `post-${idx}` },
                                                    React.createElement('a', {
                                                        href: fonte.url,
                                                        rel: 'noopener noreferrer'
                                                    }, `📌 ${fonte.titulo}`)
                                                )
                                            ),
                                            ...msg.fontes.pdfs.map((fonte, idx) =>
                                                React.createElement('li', { key: `pdf-${idx}` },
                                                    React.createElement('a', {
                                                        href: fonte.url,
                                                        target: '_blank',
                                                        rel: 'noopener noreferrer'
                                                    }, `📄 ${fonte.nome}`)
                                                )
                                            )
                                        ]
                                    )
                                )
                            )
                        )
                    )
                )
            ),
            React.createElement('div', { className: 'input-container' },
                React.createElement('textarea', {
                    ref: textareaRef,
                    className: 'chat-textarea',
                    value: query,
                    onChange: handleChange,
                    onKeyDown: handleKeyDown,
                    placeholder: 'Faça uma pergunta ...',
                    disabled: isStreaming
                }),
                React.createElement('div', { className: 'submit-container' },
                    !isStreaming && (
                        React.createElement('select', {
                            className: 'model-selector',
                            value: ollamaModel,
                            onChange: handleModelChange,
                            disabled: isStreaming
                        },
                            React.createElement('option', { value: 'mistral' }, 'Ollama - Mistral'),
                            React.createElement('option', { value: 'llama2' }, 'Ollama - Llama2'),
                            React.createElement('option', { value: 'llama3' }, 'Ollama - Llama3')
                        )
                    ),
                    (isLoading || isStreaming) && React.createElement('img', {
                        src: spinnerSrc,
                        className: 'spinner',
                        alt: 'Carregando...'
                    }),
                    isStreaming ? (
                        React.createElement('button', {
                            className: 'cancel-button',
                            onClick: cancelStream,
                            type: 'button'
                        }, 'Parar')
                    ) : (
                        React.createElement('button', {
                            className: 'submit-button',
                            onClick: handleSubmit,
                            disabled: isStreaming || query.trim() === ""
                        },
                            React.createElement('i', { className: 'fas fa-arrow-up' })
                        )
                    )
                )
            )
        )
    );
}

document.addEventListener('DOMContentLoaded', function () {
    ReactDOM.render(React.createElement(ChatGPTSearch), document.getElementById('app'));
});