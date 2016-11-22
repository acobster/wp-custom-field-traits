<?php

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : get_the_id();

$post = new Cft\Example\Post($id);
$post->hydrate();

$response = [
  'id' => $id,
  'title' => $post->post_title,
  'bar' => $post->get('bar'),
  'baz' => $post->get('baz'),
  'qux' => $post->get('qux'),
];

echo(json_encode($response));