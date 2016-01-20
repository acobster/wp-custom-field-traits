<?php

header('Content-Type: application/json');

$id = intval($_GET['id']);

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