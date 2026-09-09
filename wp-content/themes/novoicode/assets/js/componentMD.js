function MarkdownRenderer({ content }) {
    const ReactMarkdown = window.ReactMarkdown;
    if (ReactMarkdown) {
        return React.createElement(ReactMarkdown, {
            components: {
                a: (props) => {
                    return React.createElement('a', {
                        ...props,
                        target: '_blank', // Forçando todos os links a abrirem em nova aba
                        rel: 'noopener noreferrer'
                    });
                }
            }
        }, content);
    }
    return React.createElement('div', null, content);
}