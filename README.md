# Laravel Testing Roadmap — Beginner to Advanced

Welcome. This repo is a **20-minutes-a-day, 8-week program** for learning automated testing in Laravel, from "what is a test?" to a CI-backed, well-architected test suite you'd be proud to show in an interview.

If you found this repo and want to learn too: clone it, follow the days in order, do the reading, do the [tasks](./TODO.md), commit your work. Each commit is a lesson.

> **Format per day:** 📖 Reading (5–10 min) → 🛠 Task (10–15 min) → ✅ Commit.
> Don't rush ahead. Testing is a habit, not a topic — 20 focused minutes daily beats a weekend binge.

---

## 0. PHPUnit or Pest? — The Decision

**Use Pest.**

Here's the reasoning, not just the verdict:

|                   | PHPUnit                                                  | Pest                                                                                                    |
| ----------------- | -------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- |
| Syntax            | Class-based, verbose (`public function test_it_works()`) | Function-based, expressive (`it('works', function () {...})`)                                           |
| Underlying engine | Itself                                                   | **Runs on top of PHPUnit** — same assertions, same runner                                               |
| Laravel support   | First-class, always supported                            | First-class, and the **default scaffold since Laravel 8/9+**                                            |
| Extras            | —                                                        | Datasets, `expect()->toBe()` fluent API, **Arch Testing plugin**, plugins for Livewire/Faker/Watch mode |
| Learning curve    | Slightly more boilerplate                                | Faster to read/write, but you should still understand PHPUnit underneath                                |

**Why this matters for the roadmap:** because Pest is a thin, elegant layer over PHPUnit, you don't lose anything by choosing it — every PHPUnit concept (assertions, mocking, data providers, lifecycle hooks) still exists and still matters. So this roadmap teaches you **PHPUnit concepts using Pest syntax**, and calls out the PHPUnit equivalent whenever it's useful (e.g. if you join a legacy codebase that only has PHPUnit).

Official docs you'll be pointed back to constantly:

- Laravel Testing: https://laravel.com/docs/testing
- Laravel HTTP Tests: https://laravel.com/docs/http-tests
- Laravel Database Testing: https://laravel.com/docs/database-testing
- Laravel Mocking: https://laravel.com/docs/mocking
- Pest Docs: https://pestphp.com/docs/installation
- Pest Laravel Plugin: https://pestphp.com/docs/plugins#laravel
- Pest Architecture Testing: https://pestphp.com/docs/arch-testing

---

## 1. Repo & `tests/` Folder Architecture

One Laravel app lives in this repo the whole time — you build small features as you go specifically to have something to test. The test suite grows alongside it and should always mirror `app/` so anyone can find the test for any class in 5 seconds.

```
tests/
├── Pest.php                  # base config: which TestCase per dir, global helpers/expectations
├── TestCase.php               # base test case (RefreshDatabase trait hook lives here if global)
│
├── Unit/                      # NO framework boot / no DB — pure PHP logic, fast (<ms per test)
│   ├── Models/                 # accessors, mutators, scopes, casts
│   ├── Services/                # business logic classes
│   ├── Actions/                  # single-purpose action classes
│   └── Support/                    # helpers, value objects, DTOs
│
├── Feature/                   # boots the framework — HTTP, DB, routing, middleware
│   ├── Auth/                    # login, registration, password reset
│   ├── Http/
│   │   └── Controllers/           # one sub-folder per controller/resource
│   ├── Api/                     # API endpoints (JSON assertions)
│   ├── Console/                  # artisan command tests
│   └── Jobs/                    # queued job behavior (Queue::fake based)
│
├── Architecture/
│   └── ArchTest.php            # Pest Arch rules (boundaries, no debug leftovers, naming)
│
└── Datasets/                  # shared Pest datasets reused across multiple test files
```

**Rules of thumb enforced throughout this roadmap:**

- `Unit/` tests never touch the database or HTTP layer. If a test needs `RefreshDatabase` or `get()/post()`, it belongs in `Feature/`.
- Folder structure under `Unit/` and `Feature/Http/Controllers/` **mirrors `app/`** 1:1.
- One test file per class/route-group, named after the thing it tests (`UserServiceTest.php`, not `ServiceTest.php`).
- Naming convention: `it('does the specific behavior', function () {...})` — the string is a sentence, not a summary.

---

## 2. Setup (Do this before Day 1)

Laravel 12+ ships its own installer CLI — this is the modern way to start a project, and it asks you interactively whether you want Pest, which starter kit, and which database, so there's nothing to bolt on afterward.

Install the installer once (skip if you already have it):

```bash
composer global require laravel/installer
```

Then scaffold the project:

```bash
laravel new testing-roadmap
cd testing-roadmap
```

During the prompts:

- **Testing framework:** choose **Pest**
- **Database:** choose **SQLite** (fastest for a test-driven repo like this one)
- Starter kit / other options: pick "None" — keep this repo minimal so the tests stay the focus

That's it — Pest is already installed and `php artisan test` already works. If you ever need to add it manually to an existing app instead:

```bash
composer require pestphp/pest pestphp/pest-plugin-laravel --dev --with-all-dependencies
php artisan pest:install
```

Confirm SQLite in-memory is set for testing — Laravel 12's default `phpunit.xml` already includes this, but double check it has:

```xml
<php>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

Verify it works:

```bash
php artisan test
```

Commit this as **Day 0 — project scaffold**.

---

## Week 1 — Foundations

### Day 1: What is automated testing?

📖 Types of tests (unit / feature / integration), why tests > manual clicking, TDD in one paragraph. Read: https://laravel.com/docs/testing#introduction
🛠 Confirm the Day 0 setup runs. Write your first trivial test: `it('is true', fn() => expect(true)->toBeTrue());`

### Day 2: Anatomy of a Pest test

📖 `it()`/`test()`, `expect()->toBe()`, `beforeEach()`/`afterEach()`. Read: https://pestphp.com/docs/writing-tests
🛠 Write a plain PHP helper function (e.g. `formatCurrency($cents)`) in `app/Support/`, and a `Unit/Support/FormatCurrencyTest.php` with 3 assertions for different inputs.

### Day 3: PHPUnit underneath

📖 `setUp()`/`tearDown()`, `assertEquals` vs `assertSame`, test lifecycle. Read: https://docs.phpunit.de/en/10.5/writing-tests-for-phpunit.html
🛠 Rewrite yesterday's test once using raw PHPUnit assertion style (`$this->assertTrue(...)`) inside the same Pest file, just to see they're interchangeable. Delete it after — it was just to prove the point.

### Day 4: Test doubles, conceptually

📖 What's a mock vs a stub vs a fake, in plain English (no code yet). Read: https://laravel.com/docs/mocking#introduction
🛠 Pick one class you plan to build this week (e.g. a `NotificationService`) and write down (in a comment) what you'd fake vs let run for real.

### Day 5: Organizing & configuring

📖 `phpunit.xml` testsuites, Pest `uses()` per directory. Read: https://pestphp.com/docs/configuring-tests
🛠 Set up the full `tests/` folder tree from Section 1 above (empty folders with `.gitkeep`). Add `uses(Tests\TestCase::class)->in('Feature');` to `Pest.php`.

---

## Week 2 — Feature Testing (HTTP Layer)

### Day 6: Basic HTTP tests

📖 `get()`, `assertStatus()`, `assertSee()`. Read: https://laravel.com/docs/http-tests#making-requests
🛠 Build a simple `/` welcome route + controller. Test: `assertStatus(200)` and `assertSee('Welcome')`.

### Day 7: Routes with parameters

📖 Route model binding, testing 404s and redirects. Read: https://laravel.com/docs/http-tests#assert-not-found
🛠 Build `posts/{post}` show route. Test: existing post → 200, non-existent id → 404.

### Day 8: Views & data

📖 `assertViewIs()`, `assertViewHas()`. Read: https://laravel.com/docs/http-tests#assert-view-has
🛠 Test that your show route returns the right view name and passes the correct `post` variable.

### Day 9: Validation testing

📖 `assertSessionHasErrors()`, `assertRedirect()`. Read: https://laravel.com/docs/validation#quick-writing-the-validation-logic
🛠 Build a simple contact form (name, email required). Test: invalid submission → session errors; valid submission → redirect.

### Day 10: JSON / API testing

📖 `assertJson()`, `assertJsonStructure()`, `assertJsonFragment()`. Read: https://laravel.com/docs/http-tests#testing-json-apis
🛠 Build `GET /api/posts` returning JSON. Test structure and a specific fragment.

---

## Week 3 — Database Testing

### Day 11: RefreshDatabase & test DB

📖 `RefreshDatabase` trait, why in-memory SQLite for speed. Read: https://laravel.com/docs/database-testing#resetting-the-database-after-each-test
🛠 Add `RefreshDatabase` to a Feature test, confirm migrations run per test.

### Day 12: Model Factories

📖 Defining factories, states. Read: https://laravel.com/docs/eloquent-factories
🛠 Create a `PostFactory`, add a `published()` state, use it in a test via `Post::factory()->published()->create()`.

### Day 13: Database assertions

📖 `assertDatabaseHas`, `assertDatabaseMissing`, `assertDatabaseCount`. Read: https://laravel.com/docs/database-testing#available-assertions
🛠 Test that submitting your "create post" form actually persists a row with the right data.

### Day 14: Testing relationships

📖 Testing `hasMany`/`belongsTo` at the DB level. Read: https://laravel.com/docs/eloquent-relationships
🛠 Add a `User hasMany Post` relationship. Test the relation returns the right collection via factories.

### Day 15: Test isolation

📖 Why tests must not leak state into each other, common pitfalls. Read: https://laravel.com/docs/database-testing#the-lazilyrefreshdatabase-trait
🛠 Audit your Feature tests so far — make sure every one that touches DB uses `RefreshDatabase`. Fix any that don't.

---

## Week 4 — Unit Testing

### Day 16: Pure unit tests

📖 What "unit" means — no framework boot, no DB, milliseconds fast. Read: https://laravel.com/docs/testing#running-tests
🛠 Extract post-slug generation logic into a `Slugifier` service class. Unit test it with 3–4 input/output cases, no DB involved.

### Day 17: Mocking dependencies

📖 `Mockery`, Pest's `mock()`/`partialMock()` helpers. Read: https://laravel.com/docs/mocking#mockery
🛠 Give your `Slugifier` a dependency (e.g. a repository interface checking uniqueness). Mock it in a unit test.

### Day 18: Testing Model internals

📖 Accessors/mutators, local scopes. Read: https://laravel.com/docs/eloquent-mutators
🛠 Add a `scopePublished()` and a `getExcerptAttribute()` to `Post`. Unit test both.

### Day 19: Testing exceptions

📖 `expectException()`, Pest's `->throws()`. Read: https://pestphp.com/docs/exception-handling
🛠 Make `Slugifier` throw a custom exception on empty input. Test it's thrown.

### Day 20: Pest Datasets

📖 Reducing repetitive tests with datasets. Read: https://pestphp.com/docs/datasets
🛠 Convert your Slugifier's multiple input/output tests into a single test using a dataset.

---

## Week 5 — Auth, Middleware & Advanced Feature Testing

### Day 21: Authentication

📖 `actingAs()`, `assertAuthenticated()`. Read: https://laravel.com/docs/http-tests#session-and-authentication
🛠 Test a login form: valid credentials log the user in; invalid ones don't.

### Day 22: Authorization

📖 Testing Policies/Gates. Read: https://laravel.com/docs/authorization#writing-policies
🛠 Add a `PostPolicy` (only owner can edit). Test both an authorized and unauthorized attempt.

### Day 23: Middleware

📖 Testing middleware behavior through real routes. Read: https://laravel.com/docs/middleware
🛠 Write/attach a simple custom middleware (e.g. maintenance-mode-style). Test it blocks/redirects correctly.

### Day 24: File uploads

📖 `Storage::fake()`, `UploadedFile::fake()`. Read: https://laravel.com/docs/http-tests#testing-file-uploads
🛠 Add avatar upload to user profile. Test the file is stored and the path saved, using a faked disk.

### Day 25: Pagination & filtering

📖 Testing paginated/sorted listings. Read: https://laravel.com/docs/pagination
🛠 Add pagination to the posts index. Test page 2 returns different results than page 1.

---

## Week 6 — Faking Laravel's Services

### Day 26: Mail

📖 `Mail::fake()`, `assertSent()`. Read: https://laravel.com/docs/mocking#mail-fake
🛠 Send a "post published" email on creation. Test it was sent to the right recipient without actually sending it.

### Day 27: Notifications

📖 `Notification::fake()`. Read: https://laravel.com/docs/mocking#notification-fake
🛠 Convert yesterday's email into a Notification. Test it was sent via the correct channel.

### Day 28: Queues & Jobs

📖 `Queue::fake()`, `Bus::fake()`. Read: https://laravel.com/docs/mocking#queue-fake
🛠 Make the notification queued. Test the job is pushed to the queue without executing it.

### Day 29: Events

📖 `Event::fake()`. Read: https://laravel.com/docs/mocking#event-fake
🛠 Fire a `PostPublished` event on creation. Test it's dispatched with the right payload.

### Day 30: External HTTP calls

📖 `Http::fake()`, faking responses/sequences. Read: https://laravel.com/docs/http-client#testing
🛠 Build a small service calling an external API (e.g. a weather or geocoding API). Test it fully offline with `Http::fake()`.

---

## Week 7 — Advanced Topics

### Day 31: Console commands

📖 `artisan()`, `expectsQuestion()`, `assertExitCode()`. Read: https://laravel.com/docs/console-tests
🛠 Write a custom artisan command (e.g. `posts:publish-scheduled`). Test its output and exit code.

### Day 32: Task scheduling

📖 Testing the schedule includes your command. Read: https://laravel.com/docs/scheduling#testing-schedules
🛠 Schedule yesterday's command. Assert it appears on the schedule with the right frequency.

### Day 33: Architecture Testing

📖 Pest Arch plugin — enforce boundaries (no `dd()` left in, Models don't depend on Controllers, strict types). Read: https://pestphp.com/docs/arch-testing
🛠 Add `tests/Architecture/ArchTest.php` with at least 3 rules for this codebase.

### Day 34: Code coverage

📖 Generating & reading coverage reports (Xdebug/PCOV), why 100% isn't the goal. Read: https://laravel.com/docs/testing#reporting-test-coverage
🛠 Generate an HTML coverage report. Identify one untested file and add a test for it.

### Day 35: Parallel testing & speed

📖 `php artisan test --parallel`, why fast suites get run more often. Read: https://laravel.com/docs/testing#running-tests-in-parallel
🛠 Enable parallel testing. Compare before/after run time and note it in `TESTING.md`.

---

## Week 8 — CI/CD, TDD Practice & Capstone

### Day 36: Continuous Integration

📖 Running tests automatically on push. Read: https://laravel.com/docs/testing#getting-started + GitHub Actions docs
🛠 Add `.github/workflows/tests.yml` running `php artisan test` on every push/PR.

### Day 37: TDD in practice

📖 Red → Green → Refactor cycle. Read: https://laravel.com/docs/testing#introduction
🛠 Build one brand-new small feature (e.g. "archive a post") strictly TDD: write the failing test first, then the code.

### Day 38: Refactor with confidence

📖 Why a green suite lets you refactor fearlessly. Read: https://martinfowler.com/books/refactoring.html (external, background reading)
🛠 Refactor a messy controller from earlier (extract to an Action/Service class) and confirm all tests stay green.

### Day 39: Browser testing (optional, awareness-level)

📖 What Laravel Dusk adds beyond HTTP tests. Read: https://laravel.com/docs/dusk
🛠 Decide if you want Dusk in this project. If yes, install it and write one smoke test; if not, write down why in `TESTING.md`.

### Day 40: Capstone — audit & document

📖 Re-read your own `tests/` folder top to bottom as if you were a new contributor.
🛠 Write `TESTING.md` summarizing: how to run tests, folder conventions, coverage %, what's faked vs real, and what you'd add next. Push the repo public. You're done. 🎉

---

## Progress Tracker

Copy this into your own notes or a GitHub Projects board:

- [ ] Week 1 — Foundations (Days 1–5)
- [ ] Week 2 — Feature Testing (Days 6–10)
- [ ] Week 3 — Database Testing (Days 11–15)
- [ ] Week 4 — Unit Testing (Days 16–20)
- [ ] Week 5 — Auth & Advanced Feature (Days 21–25)
- [ ] Week 6 — Faking Services (Days 26–30)
- [ ] Week 7 — Advanced Topics (Days 31–35)
- [ ] Week 8 — CI/CD & Capstone (Days 36–40)

---

## How to Use This Repo If You Found It

1. Clone it.
2. Read Section 0–2 above once.
3. Start at Day 1. Don't skip the reading — it's intentionally short.
4. Do the task, commit with a message like `Day 12: model factories`.
5. Keep `tests/` mirroring `app/` the whole way — that discipline is half the lesson.
