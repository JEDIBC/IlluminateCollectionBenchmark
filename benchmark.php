<?php
use Illuminate\Support\Collection;
use Symfony\Component\Stopwatch\Stopwatch;

require_once 'vendor/autoload.php';

$iterationCount = 10000;
$events         = json_decode(file_get_contents('fabpot.json'), true);
$scores         = [
    'PushEvent'          => 5,
    'CreateEvent'        => 4,
    'IssuesEvent'        => 3,
    'CommitCommentEvent' => 2
];

/*************************************************************/

echo "=> CLASSIC\n";
$stopWatch = new Stopwatch();
$stopWatch->start('classic');
for ($i = 0; $i < $iterationCount; $i++) {
    $types = [];

    foreach ($events as $event) {
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

/*************************************************************/

echo "=> ARRAY_*\n";
$stopWatch = new Stopwatch();
$stopWatch->start('array');
for ($i = 0; $i < $iterationCount; $i++) {
    $user_score = array_sum(
        array_map(
            function ($event) use ($scores) {
                $type = $event['type'];

                return isset($scores[$type]) ? $scores[$type] : 1;
            },
            $events
        )
    );
}
$event = $stopWatch->stop('array');

$average = $event->getDuration() / $iterationCount;
echo "User has score of {$user_score}\n";
echo "{$iterationCount} iterations in {$event->getDuration()}ms: average = {$average}ms\n\n";

/*************************************************************/

echo "=> FUNCTIONAL\n";
$stopWatch = new Stopwatch();
$stopWatch->start('functional');
for ($i = 0; $i < $iterationCount; $i++) {
    $eventsCollection = new Collection($events);
    $scoresCollection = new Collection($scores);
    $user_score       = $eventsCollection->sum(
        function ($event) use ($scoresCollection) {
            return $scoresCollection->get($event['type'], 1);
        }
    );
}
$event = $stopWatch->stop('functional');

$average = $event->getDuration() / $iterationCount;
echo "User has score of {$user_score}\n";
echo "{$iterationCount} iterations in {$event->getDuration()}ms: average = {$average}ms\n\n";
