class Search {
  constructor() {
    this.isOverlayOpen = false;
    this.typingTimer;
    this.isSpinnerVisible = false;
    this.previewsValue;
    this.init();
  }

  setupDOMReferences() {
    this.openButton = document.querySelectorAll(".js-search-trigger");
    this.closeButton = document.querySelector('.search-overlay__close');
    this.searchOverlay = document.querySelector(".search-overlay");
    this.searchInput = document.querySelector("#search-term");
    this.resultsDiv = document.querySelector('#search-overlay__results');
    this.body = document.querySelector('body');
  }

  getFocusedInputs() {
    if (document.querySelector(':focus')) {
      return document.querySelector(':focus').nodeName === 'INPUT' || 'TEXTAREA' ? true : false;
    }
  }

  openOverlay(e) {
    e.preventDefault();
    this.searchOverlay.classList.add('search-overlay--active');
    this.body.classList.add('body-no-scroll');
    this.searchInput.value = '';
    setTimeout(() => {
      this.searchInput.focus({
        preventScroll: false
      });
    }, 500)
    this.isOverlayOpen = true;
  }

  closeOverlay(e) {
    this.searchOverlay.classList.remove('search-overlay--active');
    this.body.classList.remove('body-no-scroll');
    this.isOverlayOpen = false;
  }

  keyPressDispatcher(e) {
    if (e.keyCode === 83 && !this.isOverlayOpen && !this.getFocusedInputs()) {
      this.openOverlay(e)
    } else if (e.keyCode === 27 && this.isOverlayOpen) {
      this.closeOverlay(e)
    }
  }

  typingLogic(e) {
    if (this.searchInput.value != this.previewsValue) {
      clearTimeout(this.typingTimer);
      if (this.searchInput.value) {
        if (!this.isSpinnerVisible) {
          this.isSpinnerVisible = true;
          this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.innerHTML = '';
        this.isSpinnerVisible = false;
      }
    }
    this.previewsValue = this.searchInput.value;
  }

  getResults() {
    this.isSpinnerVisible = false;
    this.reqResults = [];

    try {
      Promise.all([
        fetch(`${universityData.root_url}/wp-json/wp/v2/posts?search=${this.searchInput.value}`)
          .then(resPosts => resPosts.json())
          .then(posts => posts),

        fetch(`${universityData.root_url}/wp-json/wp/v2/pages?search=${this.searchInput.value}`)
          .then(resPages => resPages.json())
          .then(pages => pages)

      ]).then(all => {
        let [postsRes, pagesRes] = all;
        this.data = postsRes.concat(pagesRes);

        this.resultsDiv.innerHTML = `
          <h2 class="search-overlay__section-title"> General information</h2>
          ${this.data.length ? `<ul class="link-list min-list">` : `<p>No general information matches that search!</p>`}
            ${this.data.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
          ${this.data.length ? `</ul>` : ''}`
        this.isSpinnerVisible = false;
      }, () => {
        this.resultsDiv.innerHTML = 'Unexpected error, please try again :D';
      });
    } catch (e) {
      console.error(e)
    }
  }








  setupEventListeners() {
    this.openButton.forEach(button => button.addEventListener("click", this.openOverlay.bind(this)));
    this.closeButton.addEventListener("click", this.closeOverlay.bind(this));
    document.addEventListener('keydown', this.keyPressDispatcher.bind(this));
    this.searchInput.addEventListener('keyup', this.typingLogic.bind(this));
  }

  init() {
    this.setupDOMReferences();
    this.setupEventListeners();
  }
}

export default Search;