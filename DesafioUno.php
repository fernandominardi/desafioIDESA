<?php

require_once 'Database.php';

class DesafioUno
{

    public static function getClientDebt(int $clientID)
    {
        Database::setDB();

        $lotes = self::getLotes();

        $cobrar['status']            = true;
        $cobrar['message']           = 'No hay Lotes para cobrar';
        $cobrar['data']['total']     = 0;
        $cobrar['data']['detail']    = [];

        foreach ($lotes as $lote) {
            if ($lote->vencimiento || $lote->vencimiento > date('Y-m-d')) continue;

            if ($lote->client_ID !== $clientID) continue;

            $cobrar['status']             = false;
            $cobrar['message']            = 'Tienes Lotes para cobrar';
            $cobrar['data']['total']     += $lote->monto;
            $cobrar['data']['detail'][]   = (array) $lote;
        }

        echo (json_encode($cobrar));
    }

    private static function getLotes(): array
    {
        $lotes = [];
        $cnx = Database::getConnection();
        $stmt = $cnx->query("SELECT * FROM debts");
        while ($rows = $stmt->fetchArray(SQLITE3_ASSOC)) {
            $rows['clientID'] = (string) $rows['clientID'];
            $lotes[] = (object) $rows;
        }
        return $lotes;
    }
}

DesafioUno::getClientDebt(123456);
