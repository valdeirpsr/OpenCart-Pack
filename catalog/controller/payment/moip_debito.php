<?php
class ControllerPaymentMoipDebito extends Controller {
	
	public function index() {
	
		//Captura o ID do Pedido
		$order_id = $this->session->data['order_id'];
		
		$data = array();
		
		//Carrega models
		$this->load->model('checkout/order');
		$this->load->model('payment/moip');
		
		//Adiciona os dados da compra no array order_info
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		//Captura a 'razão' cadastrato no módulo de pagamento MoiP no painel administrativo
		$data['nometranzacao'] = $this->config->get('moip_razao_pagamento');
		
		//Captura o 'Token' cadastrato no módulo de pagamento MoiP no painel administrativo
		$data['apitoken'] = $this->config->get('moip_token');				
		
		//Captura a 'Key' cadastrato no módulo de pagamento MoiP no painel administrativo
		$data['apikey'] = $this->config->get('moip_key');				
		
		//Captura o ID do Cliente
		$data['customer_id'] = $order_info['customer_id'];
		
		//Captura o telefone do Cliente
		$data['telephone'] = $order_info['telephone'];
		
		//Captura o tipo da moeda utilizada na compra
		$data['currency_code'] = $order_info['currency_code'];
		
		//Captura o valor total
		$data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
		
		//Captura o primeiro nome do Cliente e remove os caracteres especiais
		$data['firstname'] = $this->removeAcentos($order_info['payment_firstname']);
		
		//Captura o sobrenome do cliente e remove os caracteres especiais
		$data['lastname'] = $this->removeAcentos($order_info['payment_lastname']);
		
		//Captura o email do Cliente
		$data['email'] = $order_info['email'];
		
		//Captura o logadouro do cliente e remove os caracteres especiais
		$data['address_1'] = $this->removeAcentos($order_info['payment_address_1']);
		
		//Captura o bairro do cliente e remove os caracteres especiais
		$data['address_2'] = $this->removeAcentos($order_info['payment_address_2']);
		
		//Captura a cidade do Cliente e remove os caracteres especiais
		$data['city'] = $this->removeAcentos($order_info['payment_city']);
		
		//Captura o CEP do Cliente
		$data['postcode'] = preg_replace('/[^0-9]/', '', $order_info['payment_postcode']);
		
		//Captura o estado do Cliente
		$data['zone'] = $order_info['payment_zone_code'];
		
		//Captura o País do Cliente
		$data['country'] = $order_info['payment_country'];
		
		//Captura o id da compra
		$data['order_id'] = $order_id;
		
		//Captura o comentário do pedido
		$data['comment'] = $order_info['comment'];
		
		//Captura o código do MoIP
		$data['code'] = $this->model_payment_moip->captureToken($data);
		
		//Links
		$data['continue'] = $this->url->link('checkout/success', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/moip_debito.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/moip_debito.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/moip_debito.tpl', $data);
		}
	}
	
	private function removeAcentos($text) {
		$acentos = array('Á','À','Â','Ã','É','Ê','Í','Ó','Ô','Õ','Ú','Ç','á','à','â','ã','é','ê','í','ó','ô','õ','ú','ç','æ');
		$sAcentos = array('A','A','A','A','E','E','I','O','O','O','U','C','a','a','a','a','e','e','i','o','o','o','u','c','AE');
		
		return str_replace($acentos, $sAcentos, $text);
	}
	
	public function confirm() {
		$this->load->model('checkout/order');	
		
		$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'));
		
		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['coupon']);
		}
		
	}
}