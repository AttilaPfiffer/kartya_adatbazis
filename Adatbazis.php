<?php
class Adatbazis {
    //adattagok
    private $host = "localhost";
    private $felhasznaloNev = "root";
    private $jelszo = "";
    private $adatbazis = "magyarkartya";
    private $kapcsolat;
    //konstruktor
    public function __construct()
    {
        $this->kapcsolat = new mysqli(
            $this->host,
            $this->felhasznaloNev,
            $this->jelszo,
            $this->adatbazis
        );
        $siker = 0;
        if ($this->kapcsolat->connect_errno) {
            $siker = "Nem sikerült a kapcsolat";
        }
        else
            $siker = "Sikerült a kapcsolat";
        //echo $siker;
    }
    //metódusok
    public function adatLeker($oszlop, $tabla){
        $sql = "SELECT $oszlop FROM $tabla";
        return $this->kapcsolat->query($sql);
    }
    public function megjelenit($matrix){
        while ($sor = $matrix->fetch_row()) {
            echo "<img src=\"forras/$sor[0]\" alt=\"forras/$sor[0]\">";
        }
    }
    public function adatLeker2($oszlop1, $oszlop2, $tabla){
        $sql = "SELECT $oszlop1, $oszlop2 FROM $tabla";
        return $this->kapcsolat->query($sql);
    }
    public function megjelenit2($matrix){
        echo "<table>";
        
        while ($sor = $matrix->fetch_row()) {
            echo "<tr><th>NÉV</th><th>KÉP</th></tr>"; 
            echo "<img src=\"forras/$sor[0]\" alt=\"forras/$sor[0]\">";
            echo "</td>";
            echo "</tr>";
        }
        echo"</table>";
    }
        
    public function rekordokSzama($tabla){
        $sql = "SELECT * FROM $tabla";
        return $this->kapcsolat->query($sql)->num_rows;
    }
    public function kartyaFeltolt(){
        $szinOsszeg = $this->rekordokSzama("szin") + 1;
        $formaOsszeg = $this->rekordokSzama("forma") + 1;
        for ($szinIndex = 1; $szinIndex < $szinOsszeg; $szinIndex++) { 
            for ($formaIndex = 1; $formaIndex < $formaOsszeg; $formaIndex++){
                $sql = "INSERT INTO kartya(szinAzon, formaAzon) VALUES ('$szinIndex','$formaIndex')";
                $this->kapcsolat->query($sql);
            }
        }
    }
    public function kapcsoltBezar(){
        $this->kapcsolat->close();
    }
}
?>