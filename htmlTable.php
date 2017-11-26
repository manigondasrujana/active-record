<?php
class htmlTable
{
    static function createTable($data)
    {
        echo '<table>';
        foreach ($data as $row)
        {
            echo "<tr>";
            foreach ($row as $column) {
                echo "<td>$column</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}
?>