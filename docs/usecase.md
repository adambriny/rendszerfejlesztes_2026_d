
# Use Case diagram

A diagram a magantanar-kereso.hu.hu funkcióit mutatja be a felhasználók szemszögéből, a rendszer belső működése nélkül.

```mermaid
flowchart LR
    L["👤 Látogató / Diák"]
    T["👤 Tanár"]
    A["👤 Adminisztrátor"]

    subgraph R["magantanar-kereso.hu"]
        direction TB
        UC1(["Kezdőlap és profilok böngészése"])
        UC2(["Regisztráció és bejelentkezés"])
        UC3(["Összetett keresés és szűrés"])
        UC4(["Idősáv kiválasztása"])
        UC5(["Órafoglalás beküldése"])
        UC6(["Tanári profil és idősávok kezelése"])
        UC7(["Foglalások állapotkezelése"])
        UC8(["Értékelés és vélemény írása"])
        UC9(["Adminisztrációs moderálás"])
    end

    L --- UC1
    L --- UC2
    L --- UC3
    L --- UC4
    L --- UC5
    L --- UC8
    UC5 -. "include" .-> UC2
    UC4 -. "extend" .-> UC3

    T --- UC2
    T --- UC6
    T --- UC7

    A --- UC2
    A --- UC9
    UC6 -. "include" .-> UC2
    UC7 -. "include" .-> UC2
    UC9 -. "include" .-> UC2