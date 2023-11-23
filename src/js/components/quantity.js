function cQuantity(ini) {

  return {
    qty: ini.qty,
    changed: false,

    init: function () {
      this.qty = ini.qty;
      console.log('init');
    },

    increment: function () {
      this.changed = true;
      this.qty++;
      this.$refs['qty'].value = this.qty;
      this.onChange(this.qty);
    },

    decrement: function () {
      if(this.qty != 0) {
        this.qty--;
        this.$refs['qty'].value = this.qty;
        this.onChange(this.qty);
      }
    },

    onChange: function ($qty) {
      if($qty == ini.qty) {
        this.changed = false;
      }else {
        this.changed = true;
      }
    },
  }
}

export { cQuantity }