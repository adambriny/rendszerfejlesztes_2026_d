
# Use Case diagram

A diagram a magantanar-kereso.hu.hu funkcióit mutatja be a felhasználók szemszögéből, a rendszer belső működése nélkül.

```mermaid
flowchart TB
    L["👤 Látogató / Diák"] -- s1 --> usecaseL["Kezdőlap és profilok<br>böngészése"]
    L -- s2 --> usecaseL2["Regisztráció és<br>bejelentkezés"]
    L -- s3 --> usecaseL3["Összetett keresés<br>és szűrés"]
    L -- s4 --> usecaseL4["Idősáv kiválasztása"]
    L -- s5 --> usecaseL5["Órafoglalás<br>beküldése"]
    L -- s6 --> usecaseL6["Értékelés és vélemény<br>írása"]
    usecaseL5 -.-> usecaseL2
    usecaseL4 -.-> usecaseL3
    T["👤 Tanár"] -- s7 --> usecaseL2
    T -- s8 --> usecaseT["Tanári profil és<br>idősávok kezelése"]
    T -- s9 --> usecaseT2["Foglalások<br>állapotkezelése"]
    usecaseT -.-> usecaseL2
    usecaseT2 -.-> usecaseL2
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
| Tanár | Foglalások állapotkezelése | A tanár megnyitja a foglalásai listáját, kiválaszt egy 

A folytonos vonal azt jelzi, melyik szereplő használja az adott funkciót. Az `include` azt jelenti, hogy az egyik használati eset mindig magában foglalja a másikat. Az `extend` azt jelenti, hogy egy használati eset egy másikat bővít ki, de nem minden esetben kötelező.
