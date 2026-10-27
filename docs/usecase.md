
flowchart LR
    Latogato["Látogató"]
    Diak["Diák"]
    Tanar["Tanár"]
    Admin["Adminisztrátor"]

    subgraph Rendszer["Tanárfoglaló webalkalmazás"]
        direction TB

        UC1(["Tanárok keresése"])
        UC2(["Keresés szűrése"])
        UC3(["Tanári profil megtekintése"])
        UC4(["Regisztráció"])
        UC5(["Bejelentkezés"])

        UC6(["Szabad időpontok megtekintése"])
        UC7(["Óra foglalása"])
        UC8(["Saját foglalások kezelése"])
        UC9(["Foglalás lemondása"])
        UC10(["Tanári profil értékelése"])

        UC11(["Tanári profil kezelése"])
        UC12(["Tantárgyak kezelése"])
        UC13(["Szabad időpontok kezelése"])
        UC14(["Foglalási kérelmek kezelése"])
        UC15(["Óra megtartottként jelölése"])

        UC16(["Felhasználók kezelése"])
        UC17(["Tanári profilok moderálása"])
    end

    Latogato --- UC1
    Latogato --- UC2
    Latogato --- UC3
    Latogato --- UC4

    Diak --- UC1
    Diak --- UC2
    Diak --- UC3
    Diak --- UC5
    Diak --- UC6
    Diak --- UC7
    Diak --- UC8
    Diak --- UC9
    Diak --- UC10

    Tanar --- UC5
    Tanar --- UC11
    Tanar --- UC12
    Tanar --- UC13
    Tanar --- UC14
    Tanar --- UC15

    Admin --- UC5
    Admin --- UC16
    Admin --- UC17

    UC10 -.-> Megjegyzes["Értékelés csak legalább egy megtartott óra után adható"]

