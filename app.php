<?php

require('vendor/autoload.php');

use JonathanTorres\MediumSdk\Medium;
use Symfony\Component\Yaml\Yaml;

try {
    $configYml = Yaml::parse(file_get_contents('config/config.yml'));

    $medium = new Medium($configYml['app_config']['self_issued_token']);

    $user = $medium->getAuthenticatedUser();
    $name = $user->data->name;
    $data = [
        'title' => 'Post title from ' .$name,
        'contentFormat' => 'html',
        'content' => 'This is my post <b>BOLD</b> content.',
        'publishStatus' => 'draft',  // Could be "public", "draft", or "unlisted"
    ];

    $post = $medium->createPost($user->data->id, $data);

    echo 'Created post: ' . $post->data->title;

} catch (\Exception $e) {
    printf("Error: %s", $e->getMessage());
}
