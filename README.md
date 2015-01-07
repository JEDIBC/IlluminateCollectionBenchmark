# IlluminateCollectionBenchmark

The purpose of this project is to benchmark [illuminate/support](https://github.com/illuminate/support) Collection class after reading the blog post [Refactoring Loops and Conditionals](http://adamwathan.me/2015/01/01/refactoring-loops-and-conditionals)

## Installation & run

```bash
composer install -o
php benchmark.php
```

## Results

```
=> CLASSIC
User has score of 54
10000 iterations in 197ms : average = 0.0197ms

=> ARRAY_*
User has score of 54
10000 iterations in 869ms: average = 0.0869ms

=> FUNCTIONAL
User has score of 54
10000 iterations in 1875ms: average = 0.1875ms

```
