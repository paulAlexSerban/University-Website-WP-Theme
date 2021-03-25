class Like {
  constructor() {
    this.init();
  }

  setupDOMReferences() {
    this.likeBox = document.querySelector('.like-box');
    this.likeCount = document.querySelector('.like-count');
  }

  setupEvents() {
    if(this.likeBox) this.likeBox.addEventListener('click', this.clickDispatcher.bind(this));
  }

  clickDispatcher() {
    if(this.likeBox.getAttribute('data-exists') === 'yes') {
      this.deleteLike()
    } else if (this.likeBox.getAttribute('data-exists') === 'no') {
      this.createLike()
    }
  }

  async createLike() {
    this.professorLike = {
      'professorId': this.likeBox.dataset.professor
    }
    await fetch(`${universityData.root_url}/wp-json/university/v1/manageLike`, {
      method: 'POST',
      headers: {
        'X-WP-Nonce': `${universityData.nonce}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(this.professorLike)
    }).then(res => res.json()).then(data => {
      this.likeCountInt = parseInt(this.likeCount.innerHTML, 10);
      this.likeCountInt++;
      this.likeCount.innerHTML= this.likeCountInt;
      this.likeBox.dataset.exists = 'yes';
      this.likeBox.dataset.like = data;
    })
  }

  async deleteLike() {
    this.like = {
      'like': this.likeBox.dataset.like
    }
    await fetch(`${universityData.root_url}/wp-json/university/v1/manageLike`, {
      method: 'DELETE',
      headers: {
        'X-WP-Nonce': `${universityData.nonce}`,
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(this.like)
    }).then(res => res).then(data => {
      this.likeCountInt = parseInt(this.likeCount.innerHTML, 10);
      this.likeCountInt--;
      this.likeCount.innerHTML= this.likeCountInt;
      this.likeBox.dataset.exists = 'no';
      this.likeBox.dataset.like = '';
    })
  }

  init() {
    this.setupDOMReferences();
    this.setupEvents();
    console.log('like js inititalized')
  }
}

export default Like;