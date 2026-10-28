
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
```

## Használati esetek 

| Felhasználói szerep | Használati eset | Művelet |
|---|---|---|
| Látogató, Diák | Kezdőlap és profilok böngészése | A látogató megnyitja a weboldalt, és megtekinti a kezdőlapot vagy a tanárok profiljait. |
| Látogató, Diák | Regisztráció és bejelentkezés | A látogató a regisztráció vagy bejelentkezés menüpontra kattint, majd megadja a szükséges adatokat. |
| Látogató, Diák | Összetett keresés és szűrés | A látogató megadja a keresési feltételeket, például a tantárgyat és az árkategóriát, majd elindítja a keresést. |
|  Diák | Időpont kiválasztása | A diák megnyitja egy tanár profilját, és kiválaszt egy számára megfelelő szabad időpontot. |
|  Diák | Órafoglalás beküldése | A diák kiválaszt egy szabad időpontot, és elküldi a foglalási kérelmét, ami ekkor "függőben" állapotú. |
|  Diák  | Értékelés és vélemény írása | A diák megnyitja a tanár profilját, a véleményeknél szöveges és csillagos értékelést ad megadott karakterszámban |
| Tanár | Regisztráció és bejelentkezés | A tanár megnyitja a regisztrációs vagy bejelentkezési oldalt, és megadja a szükséges adatokat. |
| Tanár | Tanári profil és idősávok kezelése | A tanár megnyitja a profilszerkesztő felületet, és módosítja a bemutatkozását, az óradíját vagy a szabad időpontjait. |
| Tanár | Foglalások állapotkezelése | A tanár megnyitja a foglalásai listáját, kiválaszt egy foglalást, majd módosítja annak állapotát. |
| Adminisztrátor | Regisztráció és bejelentkezés | Az adminisztrátor megnyitja a bejelentkezési oldalt, és megadja a belépési adatait. |
| Adminisztrátor | Adminisztrációs moderálás | Az adminisztrátor megnyitja az adminisztrációs felületet, és elvégzi a moderálási feladatokat. |

A folytonos vonal azt jelzi, melyik szereplő használja az adott funkciót. Az `include` azt jelenti, hogy az egyik használati eset mindig magában foglalja a másikat. Az `extend` azt jelenti, hogy egy használati eset egy másikat bővít ki, de nem minden esetben kötelező.
