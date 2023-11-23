function cFeed(ini) {

  const paramFilters = window.getParam('filters');
  const pathFragments = window.location.pathname.split('page/');

  return {

    entry: ini.id,
    active: false,
    fade: false,

    showFilters: false,
    isMobile: true,

    exclude: ini.exclude,
    path: pathFragments[0],
    feed: ini.feed,
    action: '/feed/' + ini.feed + '/',

    height: 0,

    page: pathFragments[1] ? pathFragments[1] : 1,
    pathFilters: paramFilters ? paramFilters.split(':') : [],
    filters: ini.filters,
    pagination: [],
    total: 0,

    $slot: false,
    $self: false,
    $filters: false,
    $container: false,

    init: function () {

      this.$slot = this.$refs['slot'];
      this.$self = this.$root;
      this.$filters = this.$refs['filters'];
      this.$container = this.$refs['container'];
      // this.$refs['pagination-bottom'].innerHTML = this.$refs['pagination-top'].innerHTML;
      this.isMobile = !this.$breakpoint('mq480');
      this.active = true;

      this.setMinHeight();

      requestAnimationFrame(() => {
        setTimeout(() => {
          this.fade = true;
          this.height = this.$container.offsetHeight
        });
      })


    },

    toggleFilters: function () {
      this.showFilters = !this.showFilters;
      console.log(this.showFilters);
    },

    setPagination: function (pageInfo) {
      this.pagination = pageInfo;
    },

    onResize: function () {
      this.height = this.$refs['container'].offsetHeight;
      this.isMobile = !this.$breakpoint('mq480');
    },

    onTab: function () {
      requestAnimationFrame(() => {
        setTimeout(() => {
          if (this.$refs['window']) {
            this.$refs['window'].style.transitionDuration = '0s';
            setTimeout(() => { this.$refs['window'].style.transitionDuration = '' }, 300);
            this.height = this.$refs['container'].offsetHeight;
          }
        })
      })
    },

    getPagination: function (adjacentPages) {
      var items = [];

      this.total = this.pagination.total;

      if (this.pagination.totalPages === 1) { return items; }

      let diff = adjacentPages ? adjacentPages + 1 : 3;
      let start = (this.pagination.currentPage - diff < 0) ? 0 : this.pagination.currentPage - diff;
      const end = (this.pagination.currentPage + diff > this.pagination.totalPages) ? this.pagination.totalPages : this.pagination.currentPage + diff;
      const classes = window.paginationOptions.baseClass;

      if (this.pagination.currentPage > 1) {
        items.push({
          page: this.pagination.currentPage - 1,
          label: window.paginationOptions.pagePrev,
          class: classes + window.paginationOptions.interactClass,
          href: this.getPaginatedUrl(this.currentPage - 1)
        });
      }

      for (var i = start; i < (end); i++) {
        let p = i + 1;
        let href = this.getPaginatedUrl(p);
        let c = classes + ((p === this.pagination.currentPage) ? window.paginationOptions.currentClass : window.paginationOptions.interactClass);
        items.push({
          page: p,
          label: p + '',
          class: c,
          href: (p === this.pagination.currentPage) ? false : href
        });
      }

      if (this.pagination.currentPage < this.pagination.totalPages) {
        items.push({
          page: this.pagination.currentPage + 1,
          label: window.paginationOptions.pageNext,
          class: classes + window.paginationOptions.interactClass,
          href: this.getPaginatedUrl(this.currentPage + 1)
        });
      }

      return items;
    },

    getPaginatedUrl: function (page, format) {
      let path = (format === 'action') ? this.action : this.path;
      path = path.replace(/\/?$/, '/');
      let href = (page > 1) ? path + 'page/' + page + '/' : path;
      let query = '';
      for ( var key in this.filters ) {
        if ( this.filters[key].length > 0 ) {
          query += query.length > 0 ? '&' : '?';
          if ( this.filters[key].join !== undefined ) {
            query += key + '=' + this.filters[key].join(':');
          } else {
            query += key + '=' + this.filters[key];
          }
        }
      }
      if (format === 'action' && this.exclude) {
        query += query.length > 0 ? '&' : '?';
        query += 'exclude=' + this.exclude;
      }
      return href + query;
    },

    setHeight: function () {
      this.$refs['window'].style.height = '';
      let style = this.$refs['window'].getAttribute('style');
      if (style) {
        return style + '; height:' + this.height + 'px';
      }
      return 'height:' + this.height + 'px';
    },

    setMinHeight: function() {
      let filterHeight = this.$refs['filters'].clientHeight;
      this.$refs['window'].style.minHeight = filterHeight + 'px';
    },

    doFilter: function ($e) {
      $e.preventDefault();
      this.page = 1;
      this.getItems();
    },

    doReset: function ($e) {
      $e.preventDefault();
      for ( let key in this.filters) {
        this.filters[key] = [];
      }
      this.page = 1;
      this.getItems();
    },

    doPage: function ($e, page) {
      $e.preventDefault();
      this.page = page;
      this.getItems();
    },

    btnFilter: function ($e, filter) {
      if (filter) {
        this.filters = [filter]
      } else {
        this.filters = [];
      }
      this.page = 1;
      this.getItems();
    },

    btnSelected: function (filter) {
      return this.filters.includes(filter) ? "true" : "false";
    },

    getItems: function ($e) {

      this.fade = false;
      const path = this.getPaginatedUrl(this.page);
      let action = this.getPaginatedUrl(this.page, 'action');
      action += (action.indexOf('?') > 0 ? '&' : '?') + 'entry=' + this.entry;

      setTimeout(() => {
        this.active = false;
        fetch(action, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json'
          },
        }).then(response => response.json())
          .then(json => {
            history.replaceState({}, '', path);
            this.$slot.innerHTML = json.body;
            this.pagination = json.pageInfo;
            this.active = true;
            requestAnimationFrame(() => {
              setTimeout(() => {
                let height = this.$container.offsetHeight;
                this.fade = true;
                this.height = height;
                requestAnimationFrame(() => {
                  let ctnHeight = (this.$breakpoint('mq1024') && this.$filters) ? height + (this.$filters.offsetHeight) : height;
                  setTimeout(() => { this.$dispatch('feedload', { height: ctnHeight }); });
                  this.adjustScroll();
                })
                this.$self.querySelector('.c-feed').focus();
              });
            })
          });
      }, 300);
    },

    adjustScroll: function () {

      // Target is outside the view from the top
      if (this.$container.getBoundingClientRect().top > (window.innerHeight - 200)) {
        // The top of the target will be aligned to the top of the visible area of the scrollable ancestor
        window.scrollToElement(this.$container)
      }
    }

  }

}

export { cFeed }