# Daily Task Checklist

Companion to `ROADMAP.md`. Every day has **4 normal tasks** + **1 🔍 Challenge task** (requires searching docs/Google, reading beyond the summary, and thinking — not a copy-paste job). Check items off as you go; commit once a day's checklist is done.

---

## Day 0 — Project Scaffold

- [x] Task 1: Install the Laravel installer globally and run `laravel new testing-roadmap`, choosing Pest + SQLite.
- [x] Task 2: Run `php artisan test` and confirm the default example tests pass.
- [x] Task 3: Init git, commit the fresh scaffold as `Day 0: project scaffold`.
- [x] Task 4: Create the empty `tests/` sub-folders from the roadmap's architecture (`Unit/Models`, `Unit/Services`, `Feature/Http/Controllers`, `Architecture`, etc.) with `.gitkeep` files.
- [x] 🔍 Challenge: Open `phpunit.xml` and read every line. Find the Laravel docs section explaining what `<env>` overrides do during testing, and write a 2-3 sentence comment above the SQLite block explaining _why_ an in-memory DB is used instead of your real dev DB.

## Day 1 — What is Automated Testing?

- [x] Task 1: Read the "Introduction" section of the Laravel testing docs.
- [x] Task 2: Write a `Unit/Support/SanityTest.php` with one passing `it('is true', ...)` test.
- [x] Task 3: Run `php artisan test` and read the console output carefully — note what each part of the output means (dots/checks, time, memory).
- [x] Task 4: In your own words, write 3-4 bullet points in `TESTING.md` (create it) explaining unit vs feature vs integration tests.
- [x] 🔍 Challenge: Search "why TDD Red Green Refactor" and read at least one non-Laravel article on it. Summarize the 3 steps in `TESTING.md` in your own words, and note one criticism people have of strict TDD.

## Day 2 — Anatomy of a Pest Test

- [x] Task 1: Read the Pest "Writing Tests" doc page.
- [x] Task 2: Create `app/Support/formatCurrency.php` (or a class method) that converts cents to a formatted string.
- [x] Task 3: Write `Unit/Support/FormatCurrencyTest.php` with 3 separate `it()` blocks for different inputs (zero, negative, large number).
- [x] Task 4: Add a `beforeEach()` in that test file that logs/prints nothing functional yet — just to see it run before every test (add a `dump('running')` temporarily, then remove it).
- [x] 🔍 Challenge: Look up Pest's `expect()` API reference and find 3 expectation methods you haven't used yet (e.g. `toBeArray`, `toContain`, `toHaveCount`). Use each of them once in a real assertion.

## Day 3 — PHPUnit Underneath

- [x] Task 1: Read the PHPUnit "Writing Tests" docs (the assertion basics section).
- [x] Task 2: Add a `setUp()`-style `beforeEach()` and `tearDown()`-style `afterEach()` to one test file, each printing/dumping a marker so you can see the order they run in relative to your test.
- [x] Task 3: Rewrite one existing Pest test using raw `$this->assertEquals()`/`assertTrue()` syntax, run it, confirm it still passes, then revert.
- [x] Task 4: Make a short table in `TESTING.md`: Pest expectation → PHPUnit equivalent assertion (at least 5 rows).
- [x] 🔍 Challenge: Research the difference between `assertEquals` and `assertSame` in PHPUnit (loose vs strict comparison). Write one test that would pass with `assertEquals` but fail with `assertSame`, prove it, then delete the failing one and explain why in a comment.

## Day 4 — Test Doubles, Conceptually

- [x] Task 1: Read the Laravel Mocking docs introduction.
- [x] Task 2: In `TESTING.md`, write one-sentence definitions (in your own words) of: dummy, stub, fake, spy, mock.
- [x] Task 3: Sketch (in a comment or `TESTING.md`) the classes you plan to build this week: e.g. `NotificationService` depending on a `Mailer` interface.
- [x] Task 4: For that sketch, write down which dependency you'd fake vs let run for real, and why.
- [x] 🔍 Challenge: Search "mocks vs stubs Martin Fowler" and read the classic distinction. Explain in 2-3 sentences why over-mocking can make tests brittle (tests that break on refactor even though behavior didn't change).

## Day 5 — Organizing & Configuring

- [x] Task 1: Read the Pest "Configuring Tests" docs page.
- [x] Task 2: Build out the full `tests/` folder tree from the roadmap's architecture section if not already done.
- [x] Task 3: In `Pest.php`, scope `uses(Tests\TestCase::class)->in('Feature')` and confirm `Unit` tests do NOT boot the full app (they should run faster).
- [x] Task 4: Time your test suite with `php artisan test` and note the run time in `TESTING.md` as a baseline to compare against later.
- [x] 🔍 Challenge: Read about Pest's `uses()->group()` feature and PHPUnit `@group` annotations. Add a `group('slow')` or `group('fast')` tag to at least one existing test and run only that group from the CLI.

## Day 6 — Basic HTTP Tests

- [x] Task 1: Read "Making Requests" in the Laravel HTTP Tests docs.
- [x] Task 2: Build a `/` welcome route returning a view with a "Welcome" heading.
- [x] Task 3: Write a Feature test asserting `assertStatus(200)`.
- [x] Task 4: Add `assertSee('Welcome')` to the same test.
- [x] 🔍 Challenge: Look up `assertSeeInOrder()` and `assertDontSee()`. Add two more elements to your welcome page and write one test proving they appear in a specific order.

## Day 7 — Routes with Parameters

- [x] Task 1: Read the Laravel docs on Route Model Binding.
- [x] Task 2: Build a `Post` model, migration, and `posts/{post}` show route + controller.
- [x] Task 3: Test: visiting an existing post's URL returns 200.
- [x] Task 4: Test: visiting a non-existent post id returns 404 (`assertNotFound()`).
- [x] 🔍 Challenge: Research "implicit vs explicit route model binding" in Laravel. Add a custom binding (e.g. bind by `slug` instead of `id`) and write a test proving the slug-based URL resolves correctly.

## Day 8 — Views & Data

- [ ] Task 1: Read "Assert View Has" in the HTTP Tests docs.
- [ ] Task 2: Confirm your show route returns a `posts.show` view (add the view file if missing).
- [ ] Task 3: Test `assertViewIs('posts.show')`.
- [ ] Task 4: Test `assertViewHas('post')` and that the passed post matches the one from the DB.
- [ ] 🔍 Challenge: Search how to test view data more deeply using a closure, e.g. `assertViewHas('post', fn ($post) => $post->title === 'X')`. Use this pattern to assert on a nested attribute, not just the top-level variable.

## Day 9 — Validation Testing

- [ ] Task 1: Read the Laravel Validation docs "Quick Writing the Validation Logic" section.
- [ ] Task 2: Build a simple contact form (name + email, both required) with a Form Request or inline validation.
- [ ] Task 3: Test: submitting with missing fields triggers `assertSessionHasErrors(['name', 'email'])`.
- [ ] Task 4: Test: submitting valid data redirects (`assertRedirect()`).
- [ ] 🔍 Challenge: Research custom validation rules (a Rule class). Add one custom rule (e.g. email must not be from a disposable-email domain, or a business rule of your choice) and test both the pass and fail case for it.

## Day 10 — JSON / API Testing

- [ ] Task 1: Read "Testing JSON APIs" in the HTTP Tests docs.
- [ ] Task 2: Build `GET /api/posts` returning a JSON list via an API Resource.
- [ ] Task 3: Test `assertJsonStructure()` matches the expected shape (id, title, excerpt, etc.).
- [ ] Task 4: Test `assertJsonFragment()` for one specific post's data.
- [ ] 🔍 Challenge: Look into Laravel API Resource Collections and pagination meta (`links`, `meta`). Add pagination to the endpoint and write a test asserting the `meta.total` and `links.next` keys exist and behave correctly.

## Day 11 — RefreshDatabase & Test DB

- [ ] Task 1: Read "Resetting the Database After Each Test" in Database Testing docs.
- [ ] Task 2: Add `use RefreshDatabase;` to one Feature test class.
- [ ] Task 3: Prove isolation: create a row in one test, then assert in a _second_ test that the row does NOT exist.
- [ ] Task 4: Confirm migrations run automatically each test by intentionally breaking a migration and watching the suite fail.
- [ ] 🔍 Challenge: Research `LazilyRefreshDatabase` vs `RefreshDatabase` — what's the actual performance difference and when would you choose one over the other? Write your answer in `TESTING.md` and switch your base `TestCase` to whichever you decide fits this project.

## Day 12 — Model Factories

- [ ] Task 1: Read the Eloquent Factories docs.
- [ ] Task 2: Generate a `PostFactory` with realistic fake data (title, body, slug).
- [ ] Task 3: Add a `published()` state and a `draft()` state to the factory.
- [ ] Task 4: Use `Post::factory()->published()->create()` inside a test and assert on the result.
- [ ] 🔍 Challenge: Research factory relationships (`has()`, `for()`) and sequences (`Sequence` class). Create a `UserFactory` and use `Post::factory()->for(User::factory())->count(3)->create()` in one test, asserting the relationship correctly links all 3 posts to the same user.

## Day 13 — Database Assertions

- [ ] Task 1: Read "Available Assertions" in Database Testing docs.
- [ ] Task 2: Test `assertDatabaseHas('posts', [...])` after creating a post through your form.
- [ ] Task 3: Test `assertDatabaseMissing()` for data that should NOT exist after a failed/invalid submission.
- [ ] Task 4: Test `assertDatabaseCount('posts', N)` after seeding multiple posts.
- [ ] 🔍 Challenge: Look up soft deletes in Laravel (`SoftDeletes` trait) and the `assertSoftDeleted()` assertion. Add soft deletes to the `Post` model and write a test proving a "deleted" post is soft-deleted, not hard-deleted, and is excluded from normal queries.

## Day 14 — Testing Relationships

- [ ] Task 1: Read the Eloquent Relationships docs (hasMany/belongsTo section).
- [ ] Task 2: Add `User hasMany Post` and `Post belongsTo User`.
- [ ] Task 3: Test that `$user->posts` returns the correct collection using factories.
- [ ] Task 4: Test that `$post->user` returns the correct owner.
- [ ] 🔍 Challenge: Research eager loading and the N+1 query problem (`with()`, `Model::preventLazyLoading()`). Write a test that fails when lazy loading happens (using `preventLazyLoading` in a test environment) and fix the underlying query with eager loading.

## Day 15 — Test Isolation

- [ ] Task 1: Read about test isolation pitfalls in the Laravel Database Testing docs.
- [ ] Task 2: Audit every existing Feature test — confirm each one touching the DB uses `RefreshDatabase`.
- [ ] Task 3: Deliberately remove `RefreshDatabase` from one test temporarily, run the suite twice, and observe the leaking data/failure.
- [ ] Task 4: Put it back, document the lesson in `TESTING.md`.
- [ ] 🔍 Challenge: Research `php artisan test --parallel` and how database isolation works across parallel processes (separate test databases per process). Try running your current suite with `--parallel` and note any tests that fail due to hidden shared state.

## Day 16 — Pure Unit Tests

- [ ] Task 1: Read the "Running Tests" section of Laravel Testing docs, focusing on what makes a test "unit" vs "feature".
- [ ] Task 2: Extract post-slug generation into a `Slugifier` class in `app/Services/`.
- [ ] Task 3: Write `Unit/Services/SlugifierTest.php` covering a normal title, a title with special characters, and an empty string.
- [ ] Task 4: Confirm this test file does NOT extend anything that boots the framework (no DB, no HTTP).
- [ ] 🔍 Challenge: Time the difference between running just this Unit test file vs the full suite. Research why "fast unit tests" matter for developer feedback loops, and write 2-3 sentences on it in `TESTING.md`.

## Day 17 — Mocking Dependencies

- [ ] Task 1: Read "Mockery" in the Laravel Mocking docs.
- [ ] Task 2: Give `Slugifier` a dependency on a `SlugUniquenessChecker` interface.
- [ ] Task 3: In a unit test, mock that interface using Pest's `mock()` helper to return `true`/`false` for different scenarios.
- [ ] Task 4: Assert the mock's method was called with the expected argument (e.g. `->once()->with(...)`).
- [ ] 🔍 Challenge: Research the difference between `mock()`, `partialMock()`, and `spy()` in Laravel/Mockery. Rewrite one of your tests using `spy()` instead of `mock()` and explain in a comment why spies are useful when you want to assert "after the fact" rather than set expectations up front.

## Day 18 — Testing Model Internals

- [ ] Task 1: Read the Eloquent Mutators & Casting docs.
- [ ] Task 2: Add a `scopePublished()` local scope to `Post`.
- [ ] Task 3: Add a `getExcerptAttribute()` accessor that truncates the body.
- [ ] Task 4: Unit test both the scope (using an in-memory collection or lightweight factory) and the accessor.
- [ ] 🔍 Challenge: Research Laravel's newer `Attribute::make()` casting syntax vs classic `get{Field}Attribute()`. Refactor your accessor to use `Attribute::make()` and confirm your existing test still passes unchanged (a sign your test was testing behavior, not implementation).

## Day 19 — Testing Exceptions

- [ ] Task 1: Read Pest's "Exception Handling" docs page.
- [ ] Task 2: Make `Slugifier` throw a custom `EmptyTitleException` when given an empty string.
- [ ] Task 3: Test it's thrown using Pest's `->throws(EmptyTitleException::class)`.
- [ ] Task 4: Test the exception message content, not just its class.
- [ ] 🔍 Challenge: Research Laravel's exception handler / rendering (`app/Exceptions` or `bootstrap/app.php` in Laravel 12) and how to make a custom exception return a specific HTTP status when it bubbles up to a controller. Wire this up and write a Feature test hitting an endpoint that triggers it, asserting the correct status code.

## Day 20 — Pest Datasets

- [ ] Task 1: Read the Pest "Datasets" docs page.
- [ ] Task 2: Identify a test file with 3+ near-duplicate `it()` blocks (e.g. your Slugifier tests).
- [ ] Task 3: Convert them into a single test using `->with([...])`.
- [ ] Task 4: Add at least one new edge case to the dataset (e.g. unicode characters) without writing a whole new test block.
- [ ] 🔍 Challenge: Research named/shared datasets (`dataset('name', fn () => [...])` defined once and reused across files). Create one shared dataset in `tests/Datasets/` and use it in two different test files.

## Day 21 — Authentication

- [ ] Task 1: Read "Session and Authentication" in HTTP Tests docs.
- [ ] Task 2: Build/confirm a login form (Laravel's default auth scaffolding is fine, or roll your own minimal version).
- [ ] Task 3: Test valid credentials log the user in (`assertAuthenticated()`).
- [ ] Task 4: Test invalid credentials do NOT authenticate and show an error.
- [ ] 🔍 Challenge: Research `actingAs()` vs actually testing the full login form submission flow — when should you skip login with `actingAs()` in a test that's not about auth itself? Refactor 2 earlier Feature tests (from Week 2/3) that needed a logged-in user to use `actingAs()` instead of logging in manually, and explain the tradeoff in `TESTING.md`.

## Day 22 — Authorization

- [ ] Task 1: Read "Writing Policies" in the Authorization docs.
- [ ] Task 2: Generate a `PostPolicy` where only the owning user can update/delete their post.
- [ ] Task 3: Test an authorized user CAN perform the action.
- [ ] Task 4: Test an unauthorized user gets a 403 (`assertForbidden()`).
- [ ] 🔍 Challenge: Research Gates vs Policies and `Gate::before()` for admin overrides. Add an "admin can edit any post" override and write a test proving an admin bypasses the normal ownership check.

## Day 23 — Middleware

- [ ] Task 1: Read the Laravel Middleware docs.
- [ ] Task 2: Write a small custom middleware (e.g. block access during a "maintenance" flag, or require a specific header).
- [ ] Task 3: Attach it to a route/group.
- [ ] Task 4: Test a request without meeting the middleware's condition gets redirected/blocked correctly.
- [ ] 🔍 Challenge: Research middleware parameters (`middleware('throttle:5,1')` style) and testing rate limiting. Add basic throttling to one route and write a test that fires enough requests to trigger a 429, then asserts it.

## Day 24 — File Uploads

- [ ] Task 1: Read "Testing File Uploads" in HTTP Tests docs.
- [ ] Task 2: Add an avatar upload field to a user profile form.
- [ ] Task 3: Test using `Storage::fake('avatars')` and `UploadedFile::fake()->image('avatar.jpg')`.
- [ ] Task 4: Assert the file was stored (`Storage::disk('avatars')->assertExists(...)`) and the path saved on the model.
- [ ] 🔍 Challenge: Research file validation rules (`image`, `mimes:jpg,png`, `max:2048`) and testing rejection of invalid files. Write a test uploading a fake `.txt` file disguised as an avatar and assert it's rejected with a validation error.

## Day 25 — Pagination & Filtering

- [ ] Task 1: Read the Laravel Pagination docs.
- [ ] Task 2: Add pagination to the posts index page/endpoint.
- [ ] Task 3: Test that page 1 and page 2 return different sets of posts.
- [ ] Task 4: Add a simple filter (e.g. `?status=published`) and test it narrows results correctly.
- [ ] 🔍 Challenge: Research query string testing (`get('/posts?sort=oldest')`) and sorting logic. Add a "sort by oldest/newest" feature and write a test asserting the _order_ of returned items, not just their presence.

## Day 26 — Mail

- [ ] Task 1: Read "Mail Fake" in the Mocking docs.
- [ ] Task 2: Create a `PostPublishedMail` mailable sent when a post is published.
- [ ] Task 3: Test with `Mail::fake()` + `Mail::assertSent(PostPublishedMail::class)`.
- [ ] Task 4: Assert it was sent to the correct recipient using the closure form of `assertSent`.
- [ ] 🔍 Challenge: Research `Mail::assertNotSent()` and writing a test for a scenario where the email should explicitly NOT be sent (e.g. publishing a draft that's already published). Write that negative-case test.

## Day 27 — Notifications

- [ ] Task 1: Read "Notification Fake" in the Mocking docs.
- [ ] Task 2: Convert `PostPublishedMail` into a proper Notification class instead.
- [ ] Task 3: Test with `Notification::fake()` + `assertSentTo($user, PostPublishedNotification::class)`.
- [ ] Task 4: Assert it went out via the correct channel (e.g. `mail`).
- [ ] 🔍 Challenge: Research adding a second channel (e.g. `database` notifications) to the same Notification class. Add it, then write a test proving the notification is stored in the `notifications` table AND still faked for mail — i.e. test both channels from one fired notification.

## Day 28 — Queues & Jobs

- [ ] Task 1: Read "Queue Fake" in the Mocking docs.
- [ ] Task 2: Make the notification from Day 27 implement `ShouldQueue`.
- [ ] Task 3: Test with `Queue::fake()` + `assertPushed()` that the job is queued, not run inline.
- [ ] Task 4: Assert something about the job's payload (e.g. correct post/user attached) using the closure form.
- [ ] 🔍 Challenge: Research job batching (`Bus::batch()`) or job chaining (`->chain()`). Pick one small extra step (e.g. "after publishing, also clear a cache") and chain it as a second job, then write a test asserting both jobs ran in the correct order using `Bus::fake()`.

## Day 29 — Events

- [ ] Task 1: Read "Event Fake" in the Mocking docs.
- [ ] Task 2: Fire a `PostPublished` event when a post's status changes to published.
- [ ] Task 3: Test with `Event::fake()` + `Event::assertDispatched(PostPublished::class)`.
- [ ] Task 4: Assert the event carries the correct `Post` instance via the closure form of `assertDispatched`.
- [ ] 🔍 Challenge: Research `Event::fake([SpecificEvent::class])` (faking only some events, letting others run for real) and why that matters when a listener has side effects you DO want tested. Refactor your test to only fake `PostPublished` while letting an unrelated event (if any) run normally.

## Day 30 — External HTTP Calls

- [ ] Task 1: Read "Testing" section of the HTTP Client docs (`Http::fake()`).
- [ ] Task 2: Build a small service that calls an external API (weather, geocoding, or any public API of your choice).
- [ ] Task 3: Test it fully offline using `Http::fake(['api.example.com/*' => Http::response([...], 200)])`.
- [ ] Task 4: Test the service's behavior when the external API returns an error (e.g. 500) — does your app handle it gracefully?
- [ ] 🔍 Challenge: Research `Http::fakeSequence()` for simulating multiple different responses across retries, and Laravel's `retry()` helper. Add retry logic to your service for transient failures and write a test proving it retries and eventually succeeds using a fake sequence (fail, fail, succeed).

## Day 31 — Console Commands

- [ ] Task 1: Read the Laravel Console Tests docs.
- [ ] Task 2: Build a custom artisan command, e.g. `posts:publish-scheduled`.
- [ ] Task 3: Test its output using `artisan(...)->expectsOutput('...')`.
- [ ] Task 4: Test its exit code with `assertExitCode(0)`.
- [ ] 🔍 Challenge: Research `expectsQuestion()`/`expectsConfirmation()` for interactive commands. Add an interactive confirmation prompt to your command ("Are you sure? y/n") and write tests for both the "yes" and "no" paths.

## Day 32 — Task Scheduling

- [ ] Task 1: Read "Testing Schedules" in the Task Scheduling docs.
- [ ] Task 2: Schedule your Day 31 command to run daily.
- [ ] Task 3: Test the schedule includes your command with the right frequency.
- [ ] Task 4: Document in `TESTING.md` how you'd manually verify this in production vs how the test verifies it.
- [ ] 🔍 Challenge: Research scheduling on specific conditions (`->when()`) and overlapping prevention (`->withoutOverlapping()`). Add one of these to your schedule and figure out (via docs/research) how you'd realistically test that condition — write down your approach even if full testing of `when()` closures is limited.

## Day 33 — Architecture Testing

- [ ] Task 1: Read the Pest Architecture Testing docs.
- [ ] Task 2: Create `tests/Architecture/ArchTest.php`.
- [ ] Task 3: Add a rule that Models don't depend on Http Controllers (`expect('App\Models')->not->toUse('App\Http\Controllers')`).
- [ ] Task 4: Add a rule banning debug leftovers (`dd()`, `dump()`, `ray()`) anywhere in `app/`.
- [ ] 🔍 Challenge: Research custom Arch expectations (e.g. enforcing that all classes in a namespace implement an interface, or that Controllers are suffixed correctly, or `declare(strict_types=1)` everywhere). Add one custom architectural rule specific to a convention you've followed in this repo, and make sure it actually fails if you break the convention on purpose (then fix it back).

## Day 34 — Code Coverage

- [ ] Task 1: Read "Reporting Test Coverage" in the Laravel Testing docs.
- [ ] Task 2: Install/enable Xdebug or PCOV locally (whichever is easier on your machine).
- [ ] Task 3: Generate an HTML coverage report with `php artisan test --coverage`.
- [ ] Task 4: Open the report, find one file with low coverage, and add at least one meaningful test for it.
- [ ] 🔍 Challenge: Research `--min=` coverage thresholds and why chasing 100% coverage can be counterproductive (coverage ≠ correctness). Set a realistic `--min` threshold for this project, add it to your CI config placeholder, and write 3-4 sentences in `TESTING.md` on what coverage does and doesn't guarantee.

## Day 35 — Parallel Testing & Speed

- [ ] Task 1: Read "Running Tests in Parallel" in the Laravel Testing docs.
- [ ] Task 2: Run `php artisan test --parallel` and compare the time against your Day 5 baseline.
- [ ] Task 3: Fix any test that fails only in parallel mode (usually a shared-state issue).
- [ ] Task 4: Record before/after timings in `TESTING.md`.
- [ ] 🔍 Challenge: Research `ParallelTesting::setUpProcess()` / `ParallelTesting::setUpTestDatabase()` hooks for per-process setup (e.g. seeding once per process instead of per test). Use one of these hooks to optimize something in your suite and explain the speedup.

## Day 36 — Continuous Integration

- [ ] Task 1: Read the "Getting Started" testing docs section, then look up GitHub Actions' PHP setup action.
- [ ] Task 2: Create `.github/workflows/tests.yml` that installs dependencies and runs `php artisan test` on push/PR.
- [ ] Task 3: Push it and confirm the workflow runs successfully in the Actions tab.
- [ ] Task 4: Break a test on purpose, push, and confirm CI actually fails (then revert).
- [ ] 🔍 Challenge: Research caching Composer dependencies in GitHub Actions to speed up CI runs, and running your coverage threshold check (from Day 34) as a CI step that fails the build if coverage drops below your minimum. Wire it in.

## Day 37 — TDD in Practice

- [ ] Task 1: Re-read the Red-Green-Refactor cycle notes from Day 1.
- [ ] Task 2: Pick one brand-new small feature (e.g. "archive a post"). Write the failing test FIRST.
- [ ] Task 3: Write the minimum code to make it pass (Green).
- [ ] Task 4: Refactor the implementation while keeping the test green.
- [ ] 🔍 Challenge: Do a second, slightly harder TDD round on a feature with a validation rule AND a side effect (e.g. "archiving a post also cancels its scheduled notifications"). Write down, before coding, the full list of tests you predict you'll need — then compare afterward to what you actually wrote and note the gap.

## Day 38 — Refactor With Confidence

- [ ] Task 1: Re-read your earliest controller (Day 6-9 era) with fresh eyes.
- [ ] Task 2: Extract its logic into an Action or Service class.
- [ ] Task 3: Re-run the full suite and confirm everything is still green with zero test changes.
- [ ] Task 4: If a test HAD to change, ask why — was it testing behavior or implementation detail? Note the answer in `TESTING.md`.
- [ ] 🔍 Challenge: Research the concept of "tests as a refactoring safety net" vs "tests coupled to implementation" (over-mocking internals). Find one test in your suite that's too coupled to implementation details, and rewrite it to test observable behavior instead.

## Day 39 — Browser Testing (Optional Awareness)

- [ ] Task 1: Read the Laravel Dusk docs introduction.
- [ ] Task 2: Compare in `TESTING.md`: what Dusk can test that HTTP Feature tests cannot (real JS/browser behavior).
- [ ] Task 3: Decide: install Dusk and write one smoke test, OR document clearly why you're skipping it for this project.
- [ ] Task 4: If installed, run it once and confirm it opens/uses a real browser session successfully.
- [ ] 🔍 Challenge: Research running Dusk in CI (headless Chrome in GitHub Actions) — what extra setup does it need vs your existing `tests.yml`? Write the extra CI steps needed even if you don't fully wire them in, so future-you has the answer ready.

## Day 40 — Capstone: Audit & Document

- [ ] Task 1: Re-read your entire `tests/` folder top to bottom as if you were a brand-new contributor.
- [ ] Task 2: Fix any test with an unclear name or a folder that no longer mirrors `app/`.
- [ ] Task 3: Finalize `TESTING.md`: how to run tests, folder conventions, current coverage %, what's faked vs real.
- [ ] Task 4: Tag a `v1.0` release/commit and push the repo public.
- [ ] 🔍 Challenge: Write a short "What I'd add next" section in `TESTING.md` — pick 2 topics NOT covered in this roadmap (e.g. mutation testing with Infection, snapshot testing, load/performance testing) and research just enough about each to write one paragraph on what it is and why it'd matter for this project.
