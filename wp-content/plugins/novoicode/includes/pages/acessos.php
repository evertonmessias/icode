<!--Arquivo: wp-content/plugins/novoicode/includes/pages/acessos.php -->
<div class="about-novoicode">
<br>
    <h2 class="title">Registro dos últimos acessos</h2>
    <table id="tacessos" class="table table-striped table-bordered display" style="width:100%">
        <thead>
            <tr>
                <th>Usuário</th>                
                <th>IP</th>
                <th>URL</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            global $wpdb;
            $table_name = $wpdb->prefix . 'acessos';
            $sql = "SELECT * FROM $table_name ORDER BY id DESC LIMIT 500;";            
            $results = $wpdb->get_results($sql);
            foreach ($results as $item) {
                $data = explode("-", explode(" ", $item->time)[0]);
                $datahora = $data[2] . "/" . $data[1] . "/" . $data[0] . " , " . explode(" ", $item->time)[1];
                echo "<tr><td>" . $item->user . "</td><td>" . $item->ipadress . "</td><td>" . $item->url . "</td><td>" . $datahora . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>