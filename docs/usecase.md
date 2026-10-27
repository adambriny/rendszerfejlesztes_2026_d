
@startuml
left to right direction

actor "Látogató" as Latogato
actor Diák
actor Tanár
actor Adminisztrátor

rectangle "Kurzusfoglaló webalkalmazás" {
    usecase "Tanárok keresése" as UC1
    usecase "Keresés szűrése" as UC2
    usecase "Tanári profil megtekintése" as UC3
    usecase "Regisztráció" as UC4
    usecase "Bejelentkezés" as UC5

    usecase "Szabad időpontok megtekintése" as UC6
    usecase "Óra foglalása" as UC7
    usecase "Saját foglalások kezelése" as UC8
    usecase "Foglalás lemondása" as UC9
    usecase "Tanári profil értékelése" as UC10

    usecase "Tanári profil kezelése" as UC11
    usecase "Tantárgyak kezelése" as UC12
    usecase "Szabad időpontok kezelése" as UC13
    usecase "Foglalási kérelmek kezelése" as UC14
    usecase "Óra megtartottként jelölése" as UC15

    usecase "Felhasználók kezelése" as UC16
    usecase "Tanári profilok moderálása" as UC17
}

Latogato -- UC1
Latogato -- UC2
Latogato -- UC3
Latogato -- UC4

Diák -- UC1
Diák -- UC2
Diák -- UC3
Diák -- UC5
Diák -- UC6
Diák -- UC7
Diák -- UC8
Diák -- UC9
Diák -- UC10

Tanár -- UC5
Tanár -- UC11
Tanár -- UC12
Tanár -- UC13
Tanár -- UC14
Tanár -- UC15

Admin -- UC5
Admin -- UC16
Admin -- UC17

note right of UC10
  Értékelés csak akkor adható,
  ha a diák az adott tanár legalább egy óráján részt vett.

end note

@enduml
