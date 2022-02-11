class MZLDR_Front_Helper {
	/**
	 * Check whether the page is ready
	 *
	 * @param  {object}  callback
	 * 
	 * @return  void
	 */
	static onReady(callback) {
		if (document.readyState != 'loading') {
			callback();
			return;
		}
		
		document.addEventListener('DOMContentLoaded', callback);
	}
	
	/**
	 * Emit an Event
	 * 
	 * @param  {String}		 eventName
	 * @param  {DOMElement}	 element
	 * @param  {Object}		 data
	 */
	emitEvent(eventName, element, data) {
		if (!eventName) {
			return;
		}

		var event = new CustomEvent(eventName);
		element.dispatchEvent(event, { 'detail' : data, cancelable: true });
		return event;
	}

	
}