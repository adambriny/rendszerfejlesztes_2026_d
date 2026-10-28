Entity Relationship Diagram
A diagram a magantanar-kereso.hu.hu által tárolt összes adatot és azok kapcsolatait mutatja be.


erDiagram

    Felhasznalok {
        int id PK
        string email 
        string jelszo_hash
        string szerepkor
        timestamp letrehozas_datuma
    }

    TanariProfilok {
        int id PK
        int felhasznalo_id FK
        text bemutatkozas
        int oradij
        float atlag_ertekeles
    }

    Tantargyak {
        int id PK
        string nev 
    }

    TanarTantargyai {
        int tanari_profil_id PK, FK
        int tantargy_id PK, FK
    }

    SzabadIdopontok {
        int id PK
        int tanari_profil_id FK
        datetime kezdes
        datetime befejezes
    }

    Foglalasok {
        int id PK
        int diak_id FK
        int szabad_idopont_id FK
        string allapot "elfogadva, fuggoben, elutasitva"
        timestamp letrehozas_datuma
    }

    Ertekelesek {
        int id PK
        int foglalas_id FK
        int diak_id FK
        int csillagok_szama
        text velemeny
        timestamp letrehozas_datuma
    }
