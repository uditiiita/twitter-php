<?php

use PHPUnit\Framework\TestCase;

require_once '../TwitterClient.php';

class TwitterClientTests extends TestCase {
    public function testPushAndPop() {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
    
    public function testItReturnsOnlyAtleastOnceRetweetedTweets() {
        $stub = $this->createMock(Abraham\TwitterOAuth\TwitterOAuth::class);
        $stub->method('get')
             ->willReturn($this->mockTweets());
        
        $twitterClient = new Uditiiita\TwitterClient($stub);
        $tweets = $twitterClient->getTweetsWithHashTagAndMinimumOneRetweet("#any", 100);
        
        $this->assertEquals(2, count($tweets));
        $this->assertArraySubset(["id" => "2"], $tweets[0]);
        $this->assertArraySubset(["id" => "3"], $tweets[1]);
    }
    
    private function mockTweets() {
        return (object)["statuses" => [
            (object)["retweet_count" => 0, "id"=> 1],
            (object)["retweet_count" => 3, "id"=> 2],
            (object)["retweet_count" => 1, "id"=> 3],
            (object)["retweet_count" => 0, "id"=> 4]
            ]];
    }
}