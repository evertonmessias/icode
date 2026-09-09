#!/bin/bash

LOG_FILE="/var/log/icode-pdf-indexacao.log"
PYTHON_SCRIPT="/var/www/icode/wp-content/uploads/icodeia/icodeia.py"

echo "=============== Indexação & API iniciada em $(date) ===" >> "$LOG_FILE"
echo "URL: https://icode.ic.unicamp.br" >> "$LOG_FILE"

# Indexação PDF (continua igual)
curl -4 -H "User-Agent: IC-PDF-Indexer" "http://icode.messias.devsys.ic.unicamp.br/index/" >> "$LOG_FILE" 2>&1

# Indexação vetorial em Python
#echo "Iniciando indexação vetorial Python..." >> "$LOG_FILE"
# /usr/bin/python3 "$PYTHON_SCRIPT" >> "$LOG_FILE" 2>&1

echo "=============== Indexação & API finalizada em $(date) ===" >> "$LOG_FILE"
echo "" >> "$LOG_FILE"

