<?php

require_once 'Database.php';

class DesafioUno
{

    public static function getClientDebt(int $clientID)
    {
        Database::setDB();

        $lotes = self::getLotes();

        // Se invierte la lógica del booleano Status.
        $cobrar['status']            = false;
        $cobrar['message']           = 'No hay Lotes para cobrar';
        $cobrar['data']['total']     = 0;
        $cobrar['data']['detail']    = [];

        foreach ($lotes as $lote) {
            // Se separan las condiciones para primeramente verificar si el vencimiento es nulo.
            if (!$lote->vencimiento) continue;
            // Luego se verifica la fecha, con una corrección en la comparación.
            if ($lote->vencimiento <= date('Y-m-d')) continue;

            // Se corrige el nombre de la propiedad clientID.
            // Se utiliza igualdad no-estricta para comparar string e intenger.
            if ($lote->clientID != $clientID) continue;

            $cobrar['status']             = true;
            $cobrar['message']            = 'Tienes Lotes para cobrar';
            $cobrar['data']['total']     += $lote->precio;
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
