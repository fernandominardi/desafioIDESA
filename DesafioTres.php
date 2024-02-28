<?php
require_once 'Database.php';

class DesafioTres
{
    public static function retriveLotes(string $loteID): void
    {
        $loteID = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if ($loteID == 'DesafioTres.php') {
            echo json_encode(['Error' => 'Ingresar el ID del lote. Ej.: BASE_URL/DesafioTres.php/{ID}']);
            return;
        }

        Database::setDB();
        echo (json_encode(self::getLotes($loteID)));
    }

    private static function getLotes(string $loteID)
    {
        $lotes = [];

        $cnx = Database::getConnection();
        $stmt = $cnx->query("SELECT * FROM debts WHERE lote = '$loteID' ");
        while ($rows = $stmt->fetchArray(SQLITE3_ASSOC)) {
            $lotes[] = (object) $rows;
        }

        return $lotes;
    }
}

DesafioTres::retriveLotes('00148');
