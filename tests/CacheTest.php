<?php
use PHPUnit\Framework\TestCase;

require 'src/Cache.php';

class CacheTest extends TestCase {

    public function testSetAndGet() {
        Cache::set('teste_chave', ['nome' => 'Test User', 'idade' => 25], 300);
        $data = Cache::get('teste_chave');
        
        $this->assertIsArray($data);
        $this->assertEquals('Test User', $data['nome']);
        $this->assertEquals(25, $data['idade']);
    }

    public function testDelete() {
        Cache::set('chave_delete', 'valor', 300);
        Cache::delete('chave_delete');
        $data = Cache::get('chave_delete');
        
        $this->assertFalse($data);
    }
}
