var StoreService = (function() {

  var StoreService = function(key) {
    this.key = key;
  };

  StoreService.prototype.findAll = function() {
    return loadData(this.key);
  };

  StoreService.prototype.findItem = function(item) {

    var data = loadData(this.key);

    var index = findIndexByValue(data, item);

    if (index >= 0) {
      return data[index];
    }

    return undefined;

  };

  StoreService.prototype.addItem = function(item) {

    var data = loadData(this.key);

    data.push({
      value: item,
      timestamp: Date()
    });

    storeData(this.key, data);

  };

  StoreService.prototype.removeItem = function(item) {

    var data = loadData(this.key);

    var index = findIndexByValue(data, item);

    if (index >= 0) {
      data.splice(index, 1);
    }

    storeData(this.key, data);

  };

  function loadData(key) {

    var data = localStorage.getItem(key);

    if (data) {
      data = JSON.parse(data);
    } else {
      data = [];
    }

    return data;

  }

  function storeData(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
  }


  function findIndexByValue(array, value) {
    for (var i = 0; i < array.length; i++) {
      if (_.isEqual(array[i]['value'], value)) {
        return i;
      }
    }
    return -1;
  }

  return StoreService;

})();


jQuery(function() {

  jQuery('input[store-key]').each(function() {

    var inputType = jQuery(this).attr('type');
    var storeKey = jQuery(this).attr('store-key');
    var storeValue = jQuery(this).attr('store-value');
    try {
      storeValue = JSON.parse(storeValue);
    } catch (e) {
      console.log('Failed to parse value of \'store-value\' attribute:', storeValue);
    }

    switch (inputType) {

      case 'checkbox':
        initCheckbox(jQuery(this), storeKey, storeValue);
        break;

      default:
        console.log('Can\'t init storage handlers on:', this);

    }

  });

  function initCheckbox(elem, key, value) {

    var storeService = new StoreService(key);

    var data = storeService.findItem(value);
    if (data) {
      elem.prop('checked', true);
    }

    elem.change(function() {
      if (this.checked) {
        storeService.addItem(value);
      } else {
        storeService.removeItem(value);
      }
    });

  }

});
