<?php
require_once 'Database.php';

class DesafioDos
{
    // Se corrige el tipo del parámetro. En la base de datos se utiliza strings para la columna lote.
    public static function retriveLotes(string $loteID): void
    {
        Database::setDB();
        echo (json_encode(self::getLotes($loteID)));
    }

    // Se corrige el tipo del parámetro. En la base de datos se utiliza strings para la columna lote.
    private static function getLotes(string $loteID)
    {
        $lotes = [];

        $cnx = Database::getConnection();
        // Se elimina el limite de 2 registros.
        $stmt = $cnx->query("SELECT * FROM debts WHERE lote = '$loteID' ");
        while ($rows = $stmt->fetchArray(SQLITE3_ASSOC)) {
            $lotes[] = (object) $rows;
        }

        return $lotes;
    }
}

DesafioDos::retriveLotes('00148');
