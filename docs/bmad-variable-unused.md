# Cms — PHPStan variable.unused BMAD

**Module purpose:** CMS blocks/themes, style classes, footer/header config; production = actions/datas, tests = unit actions + datas.

**Why variables dead:** Empty test closures (instantiate-only skeleton) after merge; variables `$action`, `$blockData` assigned but never asserted.

**Fix applied:** Removed dead assignments (`$action =`, `$blockData =`) and kept minimal `new Class;` where instantiation is the test intent.

**Files edited (random order):**
1. `tests/Unit/Actions/GetStyleClassActionTest.php`
********
