<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new GdePosylka\Client\Client('YOUR_KEY_GOES_HERE');

$couriersResponse = $client->getCouriers()->getCouriers();
echo "List all supported couriers:\n";
foreach ($couriersResponse as $courier) {
    echo $courier->getCountryCode() . ' ' . $courier->getName() . "\n";
};

$courierSlug = 'usps';
$trackingNumber = 'ec208786464us';
$couriersResponse = $client->detectCourier($trackingNumber)->getCouriers();
echo "\nList detected couriers:\n";
// list detected couriers
foreach ($couriersResponse as $courier) {
    echo $courier->getCountryCode() . ' ' . $courier->getName() . ' ' . $courier->getTrackingNumber() . "\n";
};

$couriersResponse = $client->getValidCouriers($trackingNumber)->getCouriers();
echo "\nList valid couriers:\n";
// list detected couriers
foreach ($couriersResponse as $courier) {
    echo $courier->getCountryCode() . ' ' . $courier->getName() . ' ' . $courier->getTrackingNumber() . "\n";
};

echo "\nGet trackings list\n";
$trackList = $client->getTrackingList('default');
echo $trackList->getCountTotal(), ' ', $trackList->getCurrentPage(), ' ', $trackList->getCountOnPage(), "\n";
foreach ($trackList->getTrackings() as $trackInfo) {
    echo $trackInfo->getLastCheck()->format('Y-m-d H:i:s') . ' ' . $trackInfo->getTrackingNumber() . ' ' . $trackInfo->getTitle() . "\n";
    if ($trackInfo->getLastCheckpoint()) {
        $checkpoint = $trackInfo->getLastCheckpoint();
        echo $checkpoint->getCountryCode() . ' ' . $checkpoint->getLocation() . ' ' . $checkpoint->getTime()->format('r') . ' '
            . $checkpoint->getStatus() . ' ' . $checkpoint->getMessage() . "\n";
    }
};

$trackingNumber = 'EC208786464US';

echo "\nCreate tracking for number and courier:\n";
$fields = new GdePosylka\Client\TrackingFields();
$fields->setTitle('Test title'); // Fields are optional
$track = $client->addTracking($courierSlug, $trackingNumber, $fields);
echo $track->getCourierSlug(), ' ', $track->getTrackingNumber(), "\n";

echo "\nUpdate tracking info for number and courier:\n";
$fields = new GdePosylka\Client\TrackingFields();
$fields->setTitle('New title'); // Fields are optional here too
$track = $client->updateTracking($courierSlug, $trackingNumber, $fields);
echo $track->getCourierSlug(), ' ', $track->getTrackingNumber(), "\n";

echo "\nGet info by tracking number and courier:\n";
$trackInfo = $client->getTrackingInfo($courierSlug, $trackingNumber);
echo $trackInfo->getLastCheck()->format('Y-m-d H:i:s') . ' ' . $trackInfo->getTitle() . "\n";
foreach ($trackInfo->getCheckpoints() as $checkpoint) {
    echo $checkpoint->getCountryCode() . ' ' . $checkpoint->getLocation() . ' ' . $checkpoint->getTime()->format('r') . ' '
        . $checkpoint->getStatus() . ' ' . $checkpoint->getMessage() . "\n";
};
foreach ($trackInfo->getExtra() as $extra) {
    $data = $extra->getData();
    echo $extra->getCourierSlug(), ' ', json_encode($data) . "\n";
};

echo "\nReactivate tracking for number and courier:\n";
$track = $client->reactivateTracking($courierSlug, $trackingNumber);
echo $track->getCourierSlug(), ' ', $track->getTrackingNumber(), "\n";

echo "\nArchive tracking for number and courier:\n";
$track = $client->archiveTracking($courierSlug, $trackingNumber);
echo $track->getCourierSlug(), ' ', $track->getTrackingNumber(), "\n";

echo "\nRestore tracking for number and courier:\n";
$track = $client->restoreTracking($courierSlug, $trackingNumber);
echo $track->getCourierSlug(), ' ', $track->getTrackingNumber(), "\n";

echo "\nDelete tracking for number and courier:\n";
$track = $client->deleteTracking($courierSlug, $trackingNumber);
echo $track->getCourierSlug(), ' ', $track->getTrackingNumber(), "\n";
