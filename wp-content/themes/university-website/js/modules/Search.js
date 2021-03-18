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
    if(document.querySelector(':focus')) {
      return document.querySelector(':focus').nodeName === 'INPUT' || 'TEXTAREA' ? true : false;
    }
  }

  openOverlay() {
    this.searchOverlay.classList.add('search-overlay--active');
    this.body.classList.add('body-no-scroll');
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.classList.remove('search-overlay--active');
    this.body.classList.remove('body-no-scroll');
    this.isOverlayOpen = false;
  }

  keyPressDispatcher(e) {
    if (e.keyCode === 83 && !this.isOverlayOpen && !this.getFocusedInputs()) {
      this.openOverlay()
    } else if (e.keyCode === 27 && this.isOverlayOpen) {
      this.closeOverlay()
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
        this.typingTimer = setTimeout(this.getResults.bind(this), 1000);
      } else {
        this.resultsDiv.innerHTML = '';
        this.isSpinnerVisible = false;
      }
    }
    this.previewsValue = this.searchInput.value;
  }

  getResults() {
    this.resultsDiv.innerHTML = "imagine search results here";
    this.isSpinnerVisible = false;
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