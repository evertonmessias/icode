<div class="about-icode">
    <h1 class="title">Acessos</h1>
<table class="access">
    <tr>
        <th>id</th>
        <th>IP</th>
        <th>Data</th>
    </tr>
    <?php
    try {
        $lista = list_access('*');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    foreach ($lista as $item) {
        echo "<tr><td>" . $item->id . "</td><td>" . $item->ipadress . "</td><td>" . $item->time . "</td></tr>";
    }
    ?>
</table>
</div>