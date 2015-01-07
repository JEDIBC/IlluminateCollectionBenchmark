<?php
use Illuminate\Support\Collection;
use Symfony\Component\Stopwatch\Stopwatch;

require_once 'vendor/autoload.php';

$iterationCount = 10000;
$result         = json_decode(file_get_contents('fabpot.json'), true);

echo "=> CLASSIC\n";

$stopWatch = new Stopwatch();
$stopWatch->start('classic');
for ($i = 0; $i < $iterationCount; $i++) {
    $types = [];

    foreach ($result as $event) {
        $types[] = $event['type'];
    }

    $user_score = 0;

    foreach ($types as $type) {
        switch ($type) {
            case 'PushEvent':
                $user_score += 5;
                break;
            case 'CreateEvent':
                $user_score += 4;
                break;
            case 'IssuesEvent':
                $user_score += 3;
                break;
            case 'CommitCommentEvent':
                $user_score += 2;
                break;
            default:
                $user_score += 1;
                break;
        }
    }
}
$event = $stopWatch->stop('classic');

$average = $event->getDuration() / $iterationCount;
echo "User has score of {$user_score}\n";
echo "{$iterationCount} iterations in {$event->getDuration()}ms : average = {$average}ms\n\n";

echo "=> FUNCTIONAL\n";
$stopWatch = new Stopwatch();
$stopWatch->start('functional');
for ($i = 0; $i < $iterationCount; $i++) {
    $events = new Collection($result);

    $scores = new Collection(
        [
            'PushEvent'          => 5,
            'CreateEvent'        => 4,
            'IssuesEvent'        => 3,
            'CommitCommentEvent' => 2
        ]
    );

    $user_score = $events->sum(
        function ($event) use ($scores) {
            return $scores->get($event['type'], 1);
        }
    );
}
$event = $stopWatch->stop('functional');

$average = $event->getDuration() / $iterationCount;
echo "User has score of {$user_score}\n";
echo "{$iterationCount} iterations in {$event->getDuration()}ms: average = {$average}ms\n\n";
