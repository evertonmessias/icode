#!/bin/bash

#Arquivo: /wp-content/uploads/ci/2024/organizador_arquivos.sh

# Caminho base e configurações
BASE_DIR=$(pwd)
TIMEOUT=30

# Array de datas de referência (formato DD/MM/AAAA => ID)
declare -A DATA_REF=(
    ["19/03/2025"]=538
    ["12/02/2025"]=537
    ["11/12/2024"]=536
    ["13/11/2024"]=535
    ["11/09/2024"]=534
    ["15/05/2024"]=533
    ["10/04/2024"]=532
    ["13/03/2024"]=531
    ["07/02/2024"]=530
    ["08/11/2023"]=527
    ["11/10/2023"]=526
    ["13/09/2023"]=525
    ["09/08/2023"]=524
    ["12/07/2023"]=523
    ["14/06/2023"]=522
    ["14/12/2022"]=521
    ["16/11/2022"]=520
    ["19/10/2022"]=519
    ["21/09/2022"]=518
    ["10/08/2022"]=517
    ["10/05/2023"]=516
    ["08/03/2023"]=515
    ["08/02/2023"]=514
    ["do Institu"]=513
    ["11/05/2022"]=512
    ["20/04/2022"]=511
    ["16/03/2022"]=510
    ["09/02/2022"]=509
    ["15/12/2021"]=508
    ["10/11/2021"]=507
    ["13/10/2021"]=506
    ["08/09/2021"]=505
    ["11/08/2021"]=504
    ["09/06/2021"]=503
    ["12/05/2021"]=502
    ["14/04/2021"]=501
    ["10/03/2021"]=500
    ["09/12/2020"]=499
    ["11/11/2020"]=498
    ["14/10/2020"]=497
    ["09/09/2020"]=496
    ["12/08/2020"]=495
    ["08/07/2020"]=494
    ["10/06/2020"]=493
    ["13/05/2020"]=492
    ["12/02/2020"]=491
    ["11/03/2020"]=490
    ["27/11/2019"]=489
    ["23/10/2019"]=488
    ["18/09/2019"]=487
    ["24/07/2019"]=486
    ["19/06/2019"]=485
    ["22/05/2019"]=484
    ["17/04/2019"]=483
    ["20/02/2019"]=482
    ["21/11/2018"]=481
    ["24/10/2018"]=480
    ["19/09/2018"]=479
    ["22/08/2018"]=478
    ["18/07/2018"]=477
    ["20/06/2018"]=476
    ["23/05/2018"]=475
    ["18/04/2018"]=474
    ["21/03/2018"]=473
    ["21/02/2018"]=472
    ["18/20/2017"]=471
    ["20/09/2017"]=470
    ["23/08/2017"]=469
    ["19/07/2017"]=468
    ["28/06/2017"]=467
    ["31/05/2017"]=466
    ["26/04/2017"]=465
    ["29/03/2017"]=464
    ["30/11/2016"]=463
    ["24/08/2016"]=462
    ["25/05/2016"]=461
    ["27/04/2016"]=460
    ["23/03/2016"]=459
    ["24/02/2016"]=458
    ["30/09/2015"]=457
    ["26/08/2015"]=456
    ["29/07/2015"]=455
    ["29/04/2015"]=454
    ["25/03/2015"]=453
    ["25/02/2015"]=452
    ["12/12/2014"]=451
    ["24/10/2014"]=450
    ["08/10/2014"]=449
    ["08/10/2014"]=448
    ["08/10/2014"]=447
    ["08/10/2014"]=446
    ["08/10/2014"]=445
    ["19/09/2014"]=444
    ["26/11/2013"]=443
    ["22/11/2013"]=442
    ["22/11/2013"]=441
    ["22/11/2013"]=440
    ["28/08/2013"]=439
    ["21/06/2013"]=438
    ["27/05/2013"]=437
    ["24/04/2013"]=436
    ["24/04/2013"]=435
    ["24/04/2013"]=434
    ["13/03/2013"]=433
    ["27/02/2013"]=432
    ["20/12/2012"]=431
    ["25/11/2011"]=430
    ["26/10/2011"]=429
    ["27/09/2011"]=428
    ["26/08/2011"]=427
    ["26/08/2011"]=426
    ["26/08/2011"]=425
    ["25/04/2011"]=424
    ["13/04/2011"]=423
    ["25/03/2011"]=422
    ["18/02/2011"]=421
    ["09/11/2010"]=420
    ["22/10/2010"]=419
    ["22/10/2010"]=418
    ["22/10/2010"]=417
    ["22/10/2010"]=416
    ["20/08/2010"]=415
    ["16/08/2010"]=414
    ["26/05/2010"]=413
    ["27/04/2010"]=412
    ["26/03/2010"]=411
    ["22/02/2010"]=410
    ["07/12/2009"]=409
    ["30/11/2009"]=408
    ["23/09/2009"]=407
    ["27/08/2009"]=406
    ["29/07/2009"]=405
    ["19/06/2009"]=404
    ["19/06/2009"]=403
    ["17/04/2009"]=402
    ["06/04/2009"]=401
    ["06/04/2009"]=400
    ["06/04/2009"]=399
    ["03/03/2009"]=398
    ["03/03/2009"]=397
    ["26/02/2009"]=396
    ["12/11/2008"]=395
    ["20/10/2008"]=394
    ["08/10/2008"]=393
    ["26/09/2008"]=392
    ["05/09/2008"]=391
    ["22/08/2008"]=390
    ["13/08/2008"]=389
    ["30/07/2008"]=388
    ["28/05/2008"]=387
    ["28/05/2008"]=386
    ["28/05/2008"]=385
    ["28/05/2008"]=384
    ["28/05/2008"]=383
    ["28/05/2008"]=382
    ["28/05/2008"]=381
    ["28/05/2008"]=380
    ["28/05/2008"]=379
    ["28/05/2008"]=378
)

# Cria subpastas destino
criar_diretorios() {
    local dir="$1"
    mkdir -p "$dir/ata" "$dir/deliberacoes" "$dir/pautas" "$dir/privado"
}

# Determina subpasta com base no nome do arquivo
determinar_subdiretorio() {
    local fname=$(basename "$1")
    local lower=$(echo "$fname" | tr '[:upper:]' '[:lower:]')

    if [[ "$lower" =~ ^pauta ]]; then
        echo "pautas"
    elif [[ "$lower" =~ ^ata ]]; then
        echo "ata"
    elif [[ "$lower" =~ ^(delib|[0-9]) ]]; then
        echo "deliberacoes"
    else
        echo "privado"
    fi
}

# Extrai data textual do conteúdo do PDF
extrair_data_pdf() {
    local arquivo="$1"
    local texto=$(timeout $TIMEOUT pdftotext -layout "$arquivo" - 2>/dev/null)

    if [[ "$texto" =~ Campinas,\ ([0-9]{1,2})\ de\ ([a-zç]+)\ de\ ([0-9]{4}) ]]; then
        local dia="${BASH_REMATCH[1]}"
        local mes_nome="${BASH_REMATCH[2],,}"
        local ano="${BASH_REMATCH[3]}"

        case "$mes_nome" in
            janeiro) mes="01" ;;
            fevereiro) mes="02" ;;
            março) mes="03" ;;
            abril) mes="04" ;;
            maio) mes="05" ;;
            junho) mes="06" ;;
            julho) mes="07" ;;
            agosto) mes="08" ;;
            setembro) mes="09" ;;
            outubro) mes="10" ;;
            novembro) mes="11" ;;
            dezembro) mes="12" ;;
            *) return 1 ;;
        esac

        printf "%02d/%02d/%04d" "$dia" "$mes" "$ano"
        return 0
    fi

    return 1
}

# Usa data de modificação do arquivo
get_file_mod_date() {
    local arquivo="$1"
    date -d "$(stat -c %y "$arquivo")" "+%d/%m/%Y" 2>/dev/null
}

# Encontra o ID mais próximo da data
encontrar_id() {
    local data="$1"
    local data_ts=$(date -d "${data:6:4}-${data:3:2}-${data:0:2}" +%s 2>/dev/null)
    local id_correspondente="231"
    local menor_diff=$((2**63-1))

    while IFS= read -r linha; do
        local ref_data=$(echo "$linha" | awk '{print $1}')
        local ref_id=$(echo "$linha" | awk '{print $2}')
        local ref_ts=$(date -d "${ref_data:6:4}-${ref_data:3:2}-${ref_data:0:2}" +%s 2>/dev/null)

        if [ -z "$ref_ts" ]; then continue; fi

        local diff=$((data_ts - ref_ts))
        if [ $diff -le 0 ] && [ $(( -diff )) -lt $menor_diff ]; then
            menor_diff=$(( -diff ))
            id_correspondente="$ref_id"
        fi
    done < <(for ref in "${!DATA_REF[@]}"; do echo "$ref ${DATA_REF[$ref]}"; done | sort)

    echo "$id_correspondente"
}

# Lógica principal
processar_pdfs() {
    local total=$(find "$BASE_DIR/outros" -type f -iname "*.pdf" | wc -l)
    echo "Iniciando processamento de $total arquivos PDF..."

    find "$BASE_DIR/outros" -type f -iname "*.pdf" | while read -r pdf; do
        echo -n "Arquivo: $(basename "$pdf")... "

        if data_pdf=$(extrair_data_pdf "$pdf"); then
            echo -n "Data no PDF: $data_pdf "
        else
            data_pdf=$(get_file_mod_date "$pdf")
            echo -n "Data do sistema: $data_pdf "
        fi

        id=$(encontrar_id "$data_pdf")
        echo -n "=> ID: $id "

        subdir=$(determinar_subdiretorio "$pdf")
        destino="$BASE_DIR/$id/$subdir"
        mkdir -p "$destino"

        mv "$pdf" "$destino/" && echo "✅ Movido para $subdir/" || echo "❌ Erro ao mover!"
    done

    echo "Finalizado!"
}

# Execução
processar_pdfs
