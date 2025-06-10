<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// variabel global

$config['roles'] = ['Direktur', 'Vice President', 'Manajer Unit', 'Staf'];

$config['page_roles'] = [
  'dashboard' => [
    'Direktur',
    'Vice President',
    'Manajer Unit',
    'Staf'
  ],
  'pekerjaan_saya' => [
    'Vice President',
    'Manajer Unit',
    'Staf'
  ],
  'pemberian_pekerjaan' => [
    'Direktur',
    'Vice President',
    'Manajer Unit',
    'Junior Officer'
  ],
  'monitoring' => [
    'Direktur',
    'Vice President',
    'Manajer Unit',
    'Junior Officer'
  ],
  'hse_objective' => [
    'Staf'
  ],
  'development_commitment' => [
    'Staf'
  ],
  'community_envelopment' => [
    'Staf'
  ],
];