<?php
/**
 * Email For Download element
 *
 * @package downloadcodes.org.cashmusic
 * @author CASH Music
 * @link http://cashmusic.org/
 *
 * Copyright (c) 2013, CASH Music
 * Licensed under the Affero General Public License version 3.
 * See http://www.gnu.org/licenses/agpl-3.0.html
 *
 *
 * This file is generously sponsored by Anant Narayanan [anant@kix.in]
 * define FALSE TRUE — Just kidding.
 *
 **/
class Subscription extends ElementBase {
	public $type = 'subscription';
	public $name = 'Subscription';

	public function getData() {

		$plan_request = new CASHRequest(
			array(
				'cash_request_type' => 'commerce',
				'cash_action' => 'getsubscriptionplan',
				'user_id' => $this->element_data['user_id'],
				'id' => $this->element_data['plan_id']
			)
		);

		if ($plan_request->response['payload'] && !empty($plan_request->response['payload'][0])) {
			$this->element_data['plan_name'] = $plan_request->response['payload'][0]['name'];
			$this->element_data['plan_description'] = $plan_request->response['payload'][0]['description'];
			$this->element_data['plan_description'] = $plan_request->response['payload'][0]['description'];
			$this->element_data['plan_price'] = $plan_request->response['payload'][0]['price'];
			$this->element_data['plan_interval'] = $plan_request->response['payload'][0]['interval'];

			$this->element_data['plan_flexible_price'] =
				($plan_request->response['payload'][0]['flexible_price'] == 1) ? true: false;
		}



		if ($this->status_uid == 'asset_redeemcode_400') {
			$this->element_data['error_message'] = 'That code is not valid or has already been used.';
		} elseif ($this->status_uid == 'asset_redeemcode_200') {
			// first we "unlock" the asset, telling the platform it's okay to generate a link for non-private assets
			/*$this->element_data['asset_id'] = $this->original_response['payload']['scope_table_id'];
			if ($this->element_data['asset_id'] != 0) {
				// get all fulfillment assets
				$fulfillment_request = new CASHRequest(
					array(
						'cash_request_type' => 'asset',
						'cash_action' => 'getfulfillmentassets',
						'asset_details' => $this->element_data['asset_id'],
						'session_id' => $this->session_id
					)
				);
				if ($fulfillment_request->response['payload']) {
					$this->element_data['fulfillment_assets'] = new ArrayIterator($fulfillment_request->response['payload']);
				}
			}*/

			$this->setTemplate('success');
		}
		return $this->element_data;
	}
} // END class
?>
