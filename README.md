# Battle Simulator

A turn-based battle simulator built with **PHP 8+** and **Laravel 12**, where a hero (Kratos) fights a randomly generated monster. This project demonstrates core Object-Oriented Programming (OOP) principles and classic design patterns through clean, well-structured code.

---

## What It Does

Each battle session generates a hero and a monster with randomized stats, then runs a full turn-by-turn simulation — applying skills, calculating damage, handling luck-based dodge mechanics — and persists the result to a SQLite database. A battle history view lets you track outcomes over time.

---

## Characters & Stats

| Character | Health | Strength | Defence | Speed | Luck |
| :--- | :---: | :---: | :---: | :---: | :---: |
| **Hero (Kratos)** | 65–100 | 75–90 | 40–50 | 40–50 | 10%–20% |
| **Monster** | 50–80 | 55–80 | 50–70 | 40–60 | 30%–45% |

---

## Skills

* **Rapid Fire** — $15\%$ chance to grant the hero an extra attack in the same turn.
* **Magic Armor** — Reduces incoming damage by a random value between 5 and 10.

---

## Battle Rules

1. **First Attacker:** Determined by higher **Speed**. If there is a tie, **Luck** is used as a tiebreaker.
2. **Damage Calculation:** $$\text{Damage} = \text{Attacker Strength} - \text{Defender Defence}$$
3. **Dodge Mechanic:** If a random roll falls within the defender's **Luck** percentage, the attack is dodged entirely (0 damage).
4. **Victory Conditions:** The battle ends when an opponent reaches 0 HP, or a draw is declared after **15 turns**.

---

## OOP Design & Patterns

* **Abstract Class (`Character`):** Defines the shared structure (stats, common methods), enforcing a consistent contract across all combatants.
* **Inheritance:** `Hero` and `Monster` both extend `Character`, reusing shared logic while adding their own unique attributes and behaviors.
* **Strategy Pattern:** Skills (`RapidFire`, `MagicArmor`) are encapsulated as interchangeable strategies called through a unified interface. This makes it easy to add new skills without modifying the core battle engine.
* **Clean Code:** Responsibilities are clearly separated across dedicated classes, featuring optimized damage calculations and minimal logic duplication throughout the codebase.

---

## Tech Stack

* **Language:** PHP 8+
* **Framework:** Laravel 12
* **Database:** SQLite
* **Frontend:** Blade Templates
* **Package Manager:** Composer

---
## Screenshots

Here is a glimpse of the simulator in action:


| Battle Arena | Battle History Dashboard |
| :---: | :---: |
| <img width="1856" alt="Battle Arena - Part 1" src="https://github.com/user-attachments/assets/1d2217e8-51d0-4919-89a4-cec33a676fd0" /><br><br><img width="1803" alt="Battle Arena - Part 2" src="https://github.com/user-attachments/assets/f04b954b-79b0-4f33-b990-a5b4cb065d78" /> | <img width="1536" alt="History Dashboard - Part 1" src="https://github.com/user-attachments/assets/7d461e79-88d2-4215-9708-a79d6d324f2c" /><br><br><img width="1642" alt="History Dashboard - Part 2" src="https://github.com/user-attachments/assets/69fc9600-1b58-42a4-a003-bf57326e95de" /> |
---


## Possible Future Improvements

* [ ] Experience and leveling system for the Hero
* [ ] Multiple monster types with unique behaviors and stats
* [ ] Additional hero skills and ultimate abilities
* [ ] Battle statistics dashboard (win/loss ratios, average rounds)
* [ ] Comprehensive unit and feature tests with PHPUnit / Pest
