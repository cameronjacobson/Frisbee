<?php

namespace Frisbee;

use SimpleHttpClient\SimpleHttpClient;

class Frisbee
{
	private $http;
	private $graph;
	private $action;

	public function __construct($options){
		if(empty($options['host'])){
			throw new \Exception('must specify host');
		}
		if(empty($options['port'])){
			throw new \Exception('must specify port');
		}
		$this->http = new SimpleHttpClient(array(
			'host'=>$options['host'],
			'port'=>$options['port'],
			'contentType'=>'application/json',
			'debug'=>(bool)$options['debug']
		));
	}

	public function graph($name = null){
		$name = $name ?: $this->graph;
		if(empty($name)){
			throw new \Exception('must specify name of graph');
		}
		$response = $this->decode($this->httpRequest('/graphs/'.$name));
		return $response;
	}

	private function httpRequest($path){
		$this->http->{$this->action}($path);
		$this->http->fetch();
		$buffers = $this->http->getBuffers('body');
		$this->http->flush();
		return $buffers[1];
	}

	public function graphs(){
		$response = $this->decode($this->httpRequest('/graphs'));
		return $response['graphs'];
	}

	public function edges($id = ''){
		if(is_array($id)){
			$id = empty($id['id']) ? '' : '/'.$id['id'];
			unset($id['id']);
			$id .= '?'.http_build_query($id);
		}
		else{
			$id = empty($id) ? '' : '/'.$id;
		}
		$response = $this->decode($this->httpRequest('/graphs/'.$this->graph.'/edges'.$id));
		return $response['results'];
	}

	public function vertices($id = '', $command = ''){
		if(is_array($id)){
			$id = empty($id['id']) ? '' : '/'.$id['id'];
			unset($id['id']);
			$id .= '?'.http_build_query($id);
		}
		else{
			$id = empty($id) ? '' : '/'.$id;
			$command = empty($command) ? '' : '/'.$command;
		}
		$response = $this->decode($this->httpRequest('/graphs/'.$this->graph.'/vertices'.$id.$command));
		return $response['results'];
	}

	public function indices($data = array()){
		$tmp = '';
		if(!empty($data)){
			$tmp = '/index';
			$tmp .= empty($data['count']) ? '' : '/count?';
			$tmp .= 'key='.$data['key'];
			$tmp .= 'value='.$data['value'];
		}
		$response = $this->decode($this->httpRequest('/indices/'.$this->graph.'/indices'));
		return $response['keys'];
	}

	public function keyindices(){
		$response = $this->decode($this->httpRequest('/graphs/'.$this->graph.'/keyindices/'));
		return $response['keys'];
	}

	public function edgeKeys(){
		$response = $this->decode($this->httpRequest('/graphs/'.$this->graph.'/keyindices/edge'));
		return $response['results'];
	}

	public function vertexKeys(){
		$response = $this->decode($this->httpRequest('/graphs/'.$this->graph.'/keyindices/vertex'));
		return $response['results'];
	}

	public function setGraph($graph){
		$this->graph = $graph;
	}

	private function decode($response){
		return json_decode($response['body'],true);
	}

	public function get(){
		$this->action = 'get';
		return $this;
	}

	public function put(){
		$this->action = 'put';
		return $this;
	}

	public function post(){
		$this->action = 'post';
		return $this;
	}

	public function delete(){
		$this->action = 'delete';
		return $this;
	}
}
