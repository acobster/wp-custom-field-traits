<?php

namespace Cft\Traits;

use Cft\Plugin;
use Cft\Field\Factory;

trait HasCustomFields {
  protected $postId;
  protected $cftFields = [];

  abstract public function getFieldConfigs();

  public static function hasCustomFields( $postType = null, callable $addMeta = null, callable $save = null ) {
    $addMeta = $addMeta ?: function( $type, $wpPost ) use($postType) {
      $post = new static($wpPost->ID);
      $post->hydrate();
      $post->registerFields( $postType );
    };

    $save = $save ?: function( $id, $wpPost, $update ) {
      $post = new static($id);
      $saved = $post->save();
    };

    // TODO use post-specific action, e.g. add_meta_boxes_post...
    add_action('add_meta_boxes', $addMeta, Plugin::ACTION_PRIORITY, $numArgs = 2 );
    add_action('save_post', $save, Plugin::ACTION_PRIORITY, $numArgs = 3 );
  }

  public function hydrate() {
    $meta = $this->fetchPostMeta( $this->getPostId() );
    $builder = Plugin::getInstance()->get('fieldBuilder');

    foreach( $this->getFieldConfigs() as $name => $config ) {
      $fieldMeta = isset($meta[$name]) ? $meta[$name] : [];
      $field = $builder->build( $this->getPostId(), $name, $config, $fieldMeta );
      $this->cftFields[$name] = $field;
      $this->set( $name, $field->getValue() );
    }
  }

  public function registerFields( $postType = null ) {
    $this->registerNonce();

    foreach( $this->getFields() as $field ) {
      $field->register( $postType );
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
    if( ! wp_verify_nonce($this->getPostedValue('cft_nonce'), 'cft_save_meta') ) {
      return false;
    }

    $builder = Plugin::getInstance()->get('fieldBuilder');

    foreach( $this->getFieldConfigs() as $name => $config ) {
      $field = $builder->build(
        $this->getPostId(),
        $name,
        $config,
        $this->getPostedValue($name)
      );

      $field->save();
    }

    return true;
  }

  public function getPostId() {
    return $this->postId;
  }

  protected function getPostedValue( $name ) {
    $request = Plugin::getInstance()->get('request') ?: [];
    return isset($request[$name]) ? $request[$name] : '';
  }

  protected function registerNonce() {
    add_action( 'edit_form_after_title', function() {
      wp_nonce_field( 'cft_save_meta', 'cft_nonce' );
    });
  }

  protected function fetchPost( $id ) {
    return get_post( $id );
  }

  protected function fetchPostMeta( $id ) {
    return get_post_meta($id) ?: [];
  }
}