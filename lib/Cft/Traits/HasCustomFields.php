<?php

namespace Cft\Traits;

use Cft\Plugin;
use Cft\Field\Factory;

trait HasCustomFields {
  protected $cftFields = [];

  abstract public function getFieldConfigs();

  public static function hasCustomFields( $postType = null, callable $addMeta = null, callable $save = null ) {
    $addMeta = $addMeta ?: function( $type, $wpPost ) use($postType) {
      $post = new static($wpPost->ID);
      $post->hydrate();
      $post->renderMetaBoxes( $postType );
    };

    $save = $save ?: function( $id, $wpPost, $update ) {
      $post = new static($id);
      $post->save();
    };

    // TODO use post-specific action, e.g. add_meta_boxes_post...
    add_action('add_meta_boxes', $addMeta, Plugin::ACTION_PRIORITY, $numArgs = 2 );
    add_action('save_post', $save, Plugin::ACTION_PRIORITY, $numArgs = 3 );
  }

  public function hydrate() {
    $meta = $this->fetchPostMeta( $this->getPostId() );

    foreach( $this->getFieldConfigs() as $name => $config ) {
      $fieldMeta = isset($meta[$name]) ? $meta[$name] : [];
      $field = Factory::build( $this->getPostId(), $name, $config, $fieldMeta );
      $this->cftFields[$name] = $field;
      $this->set( $name, $field->getValue() );
    }
  }

  public function renderMetaBoxes( $postType = null ) {
    $this->renderNonce();

    foreach( $this->getFields() as $field ) {
      $field->addMetaBox( $postType );
    }
  }

  public function getFields() {
    return $this->cftFields;
  }

  public function get($field) {
    if( isset($this->cftFields[$field]) ) {
      return $this->cftFields[$field]->getValue();
    }
  }

  public function set($name, $value) {
    $this->cftFields[$name]->setValue($value);
  }

  public function save() {
    wp_verify_nonce( 'post/save', 'cft_nonce' );

    foreach( $this->getFieldConfigs() as $name => $config ) {
      $field = Factory::build( $this->getPostId(), $name, $config );
      $field->save();
    }
  }

  public function getPostId() {
    return $this->postId;
  }

  protected function renderNonce() {
    $nonce = 'post/save';

    return wp_nonce_field( $nonce, 'cft_nonce' );
  }

  protected function fetchPost( $id ) {
    return get_post( $id );
  }

  protected function fetchPostMeta( $id ) {
    return get_post_meta($id) ?: [];
  }
}