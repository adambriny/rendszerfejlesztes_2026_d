# Sequence diagram

A diagram az "Tanárok keresése", az "Idősáv kiválasztása" és az "Órafoglalás beküldése" használati esetek lépéseit mutatja be időrendben, a magantanar-kereso.hu szereplői közötti üzenetekkel.

```mermaid
sequenceDiagram
    actor D as Diák
    participant B as Böngésző
    participant S as Szerver (PHP)
    participant DB as Adatbázis (MySQL)
    participant T as Tanár

    Note over D,DB: Tanárok keresése és szűrése
    D->>B: Megadja a keresési feltételeket (tantárgy, óradíj, időpont), megnyomja a keresés gombot
    B->>S: Keresési és szűrési kérés
    S->>S: Bemenetek ellenőrzése
    S->>DB: Tanárok és szabad idősávok lekérdezése
    DB-->>S: Találatok listája
    S->>S: Eredmények rendezése és szűrése
    alt Van illeszkedő tanár és idősáv
        S-->>B: Elérhető tanárok és idősávok listája
        B-->>L: Találatok megjelenítése kártyákon
    else Nincs találat
        S-->>B: Üres eredmény
        B-->>L: "Nincs a megadott feltételeknek megfelelő tanár" üzenet
    end

    Note over D,DB: Órafoglalás kezdeményezése
    D->>B: Kiválaszt egy idősávot, kattint a "Foglalás" gombra
    B-->>D: Foglalási űrlap / megerősítő ablak megjelenítése

    Note over D,T: Órafoglalás beküldése
    D->>B: Foglalás véglegesítése, adatok elküldése
    B->>S: Foglalási kérés
    S->>S: Adatok ellenőrzése, jogosultságok vizsgálata
    alt Hibás adatok vagy foglalt idősáv
        S-->>B: Hibaüzenet
        B-->>D: Hiba jelzése a felületen
    else Helyes adatok
        S->>DB: Foglalás mentése ("függőben" / PENDING állapottal)
        DB-->>S: Mentés sikeres
        S->>T: Értesítés küldése az új órafoglalásról
        S-->>B: Sikeres foglalás üzenete
        B-->>D: Visszajelzés a foglalás rögzítéséről
    end