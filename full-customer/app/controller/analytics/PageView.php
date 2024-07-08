<?php

namespace Full\Customer\Analytics;

use DateTimeImmutable;

class PageView
{
  public int $id;
  public string $session = 'unknown';
  public DateTimeImmutable $createdAt;
  public string $page = '/';
  public string $queryString = '';

  public function __construct()
  {
  }

  public function save(): void
  {
    global $wpdb;

    if (isset($this->id)) :
      return;
    endif;

    if (!isset($this->createdAt)) :
      $this->createdAt = new DateTimeImmutable(current_time('Y-m-d H:i:s'));
    endif;

    $wpdb->insert(
      Database::$table,
      [
        'session' => $this->session,
        'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        'page' => $this->page,
        'queryString' => $this->queryString
      ],
      [
        '%s',
        '%s',
        '%s',
        '%s'
      ]
    );
  }
}
