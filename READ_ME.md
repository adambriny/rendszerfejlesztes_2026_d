# Projektterv és Rendszerspecifikáció: Oktatási Oldal (Magántanár Kereső Platform)

---

## 1. Projektösszefoglaló (Project Overview)

### 1.1 Célkitűzés
A projekt célja egy olyan oktatási webplatform létrehozása (a *MyProfessor* mintájára), amely összeköti a magántanárokat a tanulni vágyó diákokkal. A platform lehetővé teszi a diákok számára, hogy tantárgy, óradíj, értékelés és szabad időpontok alapján kereszenek tanárokat, és közvetlenül időpontot foglaljanak hozzájuk. 

### 1.2 Fő funkciók
- Két elkülönített bejelentkezési és kezelőfelület (Tanári és Diák felület).
- Összetett szűrés és keresés (tantárgy, ár/óra, elérhetőség).
- Tanári naptár- és időpontkezelés (foglalható idősávok megadása).
- Diák órafoglalási rendszer és foglaláskezelés.
- Értékelési és visszajelzési rendszer a megtartott órák után.

---

## 2. Felhasználói Szerepkörök és Bejelentkezési Felületek

| Szerepkör | Bejelentkezési Felület | Jogosultságok és Funkciók |
|---|---|---|
| **Látogató (Guest)** | Nincs (Publikus) | Tanárok keresése és böngészése, regisztráció indítása. |
| **Diák (Student)** | Diák Bejelentkezés (`/login/student`) | Keresés, szűrés, időpontfoglalás, saját foglalások lemondása/kezelése, értékelés írása. |
| **Tanár (Teacher)** | Tanár Bejelentkezés (`/login/teacher`) | Profil szerkesztése (tantárgyak, óradíj, bemutatkozás), szabad idősávok feltöltése/törlése, foglalások elfogadása/elutasítása. |
| **Adminisztrátor** | Admin Felület (`/admin`) | Felhasználók kezelése, visszaélések/nem megfelelő profilok moderálása. |

---

## 3. Funkcionális Követelmények (Functional Requirements)

| ID | Követelmény neve | Leírás | Szerepkör | Prioritás |
|---|---|---|---|---|
| **F01** | Tanári Regisztráció és Belépés | Tanárok fiókregisztrációja és bejelentkezése a tanári felületen. | Tanár | High |
| **F02** | Diák Regisztráció és Belépés | Diákok fiókregisztrációja és bejelentkezése a diák felületen. | Diák | High |
| **F03** | Tanári Profil Kezelése | Személyes adatok, bemutatkozó szöveg, oktatott tantárgyak és óradíjak beállítása. | Tanár | High |
| **F04** | Szabad Időpontok Kezelése | Tanárok által felvitt foglalható idősávok (naptári integráció). | Tanár | High |
| **F05** | Összetett Keresés & Szűrés | Tanárok listázása tantárgy, óradíj (min-max) és elérhető időpontok szerint. | Diák / Látogató | High |
| **F06** | Órafoglalás | Diák által kiválasztott szabad idősáv lefoglalása. | Diák | High |
| **F07** | Foglalások Állapotkezelése | Foglalások nyomon követése (Függőben / Elfogadva / Elutasítva / Lemondva). | Diák, Tanár | Medium |
| **F08** | Értékelési Rendszer | Megtartott óra után a diák 1–5 csillagos értékelést és szöveges véleményt írhat. | Diák | Low |

---

## 4. Nem-funkcionális Követelmények (Non-Functional Requirements)

### 4.1 Biztonság (Security)
- Jelszavak biztonságos tárolása **Bcrypt** / **Argon2** hashelési eljárással.
- **Munkamenet-kezelés & RBAC:** Szerepkör-alapú hozzáférés-vezérlés (JWT vagy Session-alapú hitelesítéssel), amely megakadályozza, hogy diák hozzáférjen tanári funkciókhoz és fordítva.
- HTTPS protokoll használata az adatátvitel védelmére.

### 4.2 Teljesítmény és Skálázhatóság (Performance)
- Az adatbázis lekérdezések (keresés/szűrés) válaszideje átlagos terhelés mellett ne haladja meg az 1 másodpercet.
- Megfelelő adatbázis indexelés a tantárgyak és időpontok gyors szűréséhez.

### 4.3 Használhatóság (Usability)
- Reszponzív felület (Desktop, Tablet, Mobil nézet támogatása).
- Áttekinthető, 2 különálló bejelentkezési gomb/felület a főoldalon.

---

## 5. Adatbázis-terv és Architektúra

### 5.1 Adatbázis Entitások (ER Modell alapok)

1. **Users**
   - `id` (PK, INT / UUID)
   - `email` (VARCHAR, Unique)
   - `password_hash` (VARCHAR)
   - `role` (ENUM: 'STUDENT', 'TEACHER', 'ADMIN')
   - `created_at` (TIMESTAMP)

2. **TeacherProfiles**
   - `id` (PK)
   - `user_id` (FK -> Users.id)
   - `bio` (TEXT)
   - `hourly_rate` (INT)
   - `rating_avg` (FLOAT)

3. **Subjects**
   - `id` (PK)
   - `name` (VARCHAR) — *pl. Matematika, Fizika, Angol, C# Programozás*

4. **TeacherSubjects**
   - `teacher_id` (FK -> TeacherProfiles.id)
   - `subject_id` (FK -> Subjects.id)

5. **Availabilities**
   - `id` (PK)
   - `teacher_id` (FK -> TeacherProfiles.id)
   - `start_time` (DATETIME)
   - `end_time` (DATETIME)
   - `is_booked` (BOOLEAN, default: false)

6. **Bookings**
   - `id` (PK)
   - `student_id` (FK -> Users.id)
   - `availability_id` (FK -> Availabilities.id)
   - `status` (ENUM: 'PENDING', 'CONFIRMED', 'CANCELLED')
   - `created_at` (TIMESTAMP)

---

## 6. Projekt Ütemterv és Mérföldkövek (Milestones)

| Mérföldkő | Feladat / Tevékenység | Határidő / Status |
|---|---|---|
| **M1: Tervezés** | Követelményfelmérés, Projektterv.md elkészítése, DB ER-modell megtervezése. | Kész |
| **M2: Backend & DB** | Adatbázis sémák létrehozása, regisztráció/bejelentkezés (Auth) API megírása. | Folyamatban |
| **M3: Tanári Felület** | Tanári profilkezelés és szabad időpontok (Naptár) kezelésének fejlesztése. | Tervezett |
| **M4: Diák Felület** | Keresési/Szűrési felület és Órafoglalási folyamat megvalósítása. | Tervezett |
| **M5: Tesztelés & Kiadás** | Rendszertesztelés, hibajavítás, végső dokumentáció és demonstráció. | Tervezett |

---
## 7. Projektcsapat


| Név | GitHub felhasználónév | Szerepkör | Fő felelősségi terület |
|---|---|---|---|
| Indul Alexandra | `@Lexa7842` | Projektmenedzser, fejlesztő | Feladatok kiosztása, ütemezés, Adatbázis |
| Busa Sarah Michelle| `@Rosebeth886` | Backend Fejlesztő | Backend API, Adatbázis architektúra |
| Kovács Anabella | `@annabellakovacs` | Frontend Fejlesztő | Frontend UI/UX, Keresési és szűrési modulok |