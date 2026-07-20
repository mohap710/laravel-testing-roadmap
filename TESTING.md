## Unit vs Feature vs Integration tests

#### 1. Unit

- Unit test focus on individual code typically a method
- example: testing `isEven(int $number):bool` method return `true` if the number passed is even, otherwise `false`

#### 2. Feature

- Feature test focus on a complete user Journey to ensure the business logic works well as whole
- example: testing the `/api/register POST` with a valid payload and ensure it returns a `201 Created` response, sends a welcome email, and navigate the user to the profile page

#### 3. Integration

- Integration test focus on how Modules interacts with each other
- example: Verifying that a `UserRepository` successfully saves a record to a live test PostgreSQL database and reads it back without data type mismatch errors.

---

## Why TDD Red Green Refactor ?

**Test-Driven Development** is a programming practice where the test drive the software development.

- 🔴 **Red stage**: Writes a failing test case on the feature we want to implement.
- 🟢 **Green stage**: Implement the Feature so the test case can pass with minimal code.
- 🔵 **Refactor stage**: Improve on the existing solution, making sure that the test still passes.

A common criticism is that TDD can slow you down in some situations, especially when:

- requirements are unclear
- you’re exploring or prototyping
- working on UI or integrations

In these cases, writing tests first can feel like extra overhead without immediate benefit.

---

## Pest Expectation and PhpUnit Equivalent Assertion

| Pest                    | PHPUnit                    |
| ----------------------- | -------------------------- |
| `toBeLessThanOrEqual()` | `assertLessThanOrEqual()`  |
| `json()`                | `assertJson()`             |
| `toStartWith()`         | `assertStringStartsWith()` |
| `toBeArray() `          | `assertIsArray()`          |
| `toHaveKeys()`          | `assertArrayHasKey()`      |

---

## Test Doubles

In software testing, we use `Test Doubles`—a term coined by `Gerard Meszaros`—as a clever way to replace real components (like databases or APIs) with controlled substitutes.

| Type      | Goal                             | Behavior                               |
| :-------- | :------------------------------- | :------------------------------------- |
| **Dummy** | Fulfill a parameter requirement. | Does nothing; just occupies space.     |
| **Stub**  | Provide input for the test.      | Returns hard-coded data.               |
| **Fake**  | Simpler version of reality.      | Functional code (but shortcut-heavy).  |
| **Spy**   | Observe what happened.           | Records interactions for later check.  |
| **Mock**  | Verify strict behavior.          | Fails if interactions aren't followed. |

---

## What to fake and what to let run actually ?

1.  Fake the "Outside World"
    Anything that lives outside your server or talks to other services should be faked.

        - External APIs & Gateways: Because they are slow, cost money, or might be down, replace them with a Stub or Mock.

        - Databases: Because real database setups are slow and complex, use an In-Memory Fake to simulate data storage without the overhead.

2.  Run the "Logic" for Real
    Anything that calculates, organizes, or makes decisions should be tested for real.

        - Business Rules: If your code decides when to send a notification (e.g., "only send if the user is a VIP"), test that logic for real to make sure your rules work.

        - Data Formatting: If your code turns raw data into a formatted message or template, run that code for real to ensure the output looks exactly as intended.

---

## Why over-mocking can make tests brittle

Over mocking makes test tightly couple to the process not the end result.
Imagine a `processOrder()` function that calls `saveToDatabase()` function So your program mock expect `saveToDatebase()` to be called ,
so if you later refactor your code to use `batchSave()` the test will breaks. even though the order is saved to database correctly.
because we are testing the steps not the final result.

**Key Takeaway**: If your tests break every time you clean up or reorganize your code, you are likely testing the "**how**" instead of the "**what**".

## Testing Duration time at Day 5

- Tests: 13 passed (15 assertions)
- Duration: 1.41s
