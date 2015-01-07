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
10000 iterations in 199ms : average = 0.0199ms

=> FUNCTIONAL
User has score of 54
10000 iterations in 1936ms: average = 0.1936ms
```
