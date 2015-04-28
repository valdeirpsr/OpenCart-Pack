<?php
class ModelPaymentMoipCartao extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/moip');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('moip_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'moip_cartao',
				'title'      => $this->language->get('text_cartao'),
				'terms'      => '',
				'sort_order' => $this->config->get('moip_sort_order')
			);
		}

		return $method_data;
	}
}