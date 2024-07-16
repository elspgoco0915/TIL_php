- Refactoring-guru
    - ex) 
    - http://localhost:8080/studies/refactoring-guru/factory-method/conceptual/
    - http://localhost:8080/studies/refactoring-guru/strategy/conceptual/
    - http://localhost:8080/studies/refactoring-guru/strategy/realworld/


```bash
#!/bin/bash
// pwd TIL_php 直下で実行する

create_pattern_tmp () {
    echo "create..."

    PATTERN=$1
    mkdir -p src/htdocs/studies/refactoring-guru/$PATTERN/conceptual
    touch src/htdocs/studies/refactoring-guru/$PATTERN/conceptual/index.php
    mkdir -p src/htdocs/studies/refactoring-guru/$PATTERN/realworld
    touch src/htdocs/studies/refactoring-guru/$PATTERN/realworld/index.php

    echo "http://localhost:8080/studies/refactoring-guru/${PATTERN}/conceptual/\n"
    echo "http://localhost:8080/studies/refactoring-guru/${PATTERN}/realworld/\n"
    echo "done."
}
create_pattern_tmp {任意のパターン名}
```