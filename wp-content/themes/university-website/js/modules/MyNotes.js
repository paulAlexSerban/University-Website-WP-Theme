class MyNotes {
  constructor() {
    this.init()
  }

  setupDomReferences() {
    this.notesList = document.querySelector('#myNotes');
    this.createNoteButton = document.querySelector('.submit-note');
  }

  setupEvents() {
    this.notesList.addEventListener('click', e => {
      if (e.target.classList.contains(`delete-note`)) this.deleteNote(e)
    });
    this.notesList.addEventListener('click', e => {
      if (e.target.classList.contains(`edit-note`)) this.editNote(e)
    });
    this.notesList.addEventListener('click', e => {
      if (e.target.classList.contains(`update-note`)) this.saveNote(e)
    });
    if (this.createNoteButton) this.createNoteButton.addEventListener('click', this.createNote.bind(this));
  }

  async deleteNote(e) {
    this.note = e.target.parentNode;
    if (this.note.tagName === 'LI') this.dataId = this.note.dataset.id;

    await fetch(`${universityData.root_url}/wp-json/wp/v2/note/${this.dataId}`, {
        method: 'DELETE',
        headers: {
          'X-WP-Nonce': `${universityData.nonce}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(null)
      }).then(res => res.json()).then(data => {
        this.note.remove();
        document.querySelector('.note-limit-message').classList.remove('active');
      })
  }

  async saveNote(e) {
    this.noteToSave = e.target.parentNode;
    this.innerElements = this.getInnerElements(this.noteToSave);
    this.updatedPost = {
      'title': this.innerElements.inputTitle.value,
      'content': this.innerElements.textarea.value
    }
    if (this.noteToSave.tagName === 'LI') this.dataId = this.noteToSave.dataset.id;

    await fetch(`${universityData.root_url}/wp-json/wp/v2/note/${this.dataId}`, {
        method: 'POST',
        headers: {
          'X-WP-Nonce': `${universityData.nonce}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.updatedPost)
      }).then(res => res.json()).then(data => this.makeNoteReadOnly(this.getInnerElements(this.noteToSave)));
  }

  async createNote(e) {
    this.ourNewPost = {
      'title': e.target.parentNode.querySelector('.new-note-title').value,
      'content': e.target.parentNode.querySelector('.new-note-body').value,
      'status': 'publish'
    }

      await fetch(`${universityData.root_url}/wp-json/wp/v2/note/`, {
        method: 'POST',
        headers: {
          'X-WP-Nonce': `${universityData.nonce}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.ourNewPost)
      }).then(res => res.json()).then(data => {
        this.newPostItem = document.createElement('LI');
        this.newPostItem.classList.add('note__item');
        this.newPostItem.setAttribute('data-state', 'readonly');
        this.newPostItem.setAttribute('data-id', data.id);
        this.newPostItem.innerHTML = `
        <input readonly class="note-title-field" type="text" name="" value="${data.title.raw}">
        <span class="edit-note">
          <i class="far fa-edit" aria-hidden="true"></i> Edit
        </span>
        <span class="delete-note"><i class="fas fa-trash" aria-hidden="true"></i> Delete</span>
        <textarea readonly class="note-body-field" name="" cols="30"
          rows="10">${data.content.raw}</textarea>
        <span class="update-note btn btn--blue btn--small">
          <i class="fas fa-arrow-right" aria-hidden="true"></i> Save
        </span>`;

        e.target.parentNode.querySelector('.new-note-title').value = '';
        e.target.parentNode.querySelector('.new-note-body').value = '';

        this.notesList.insertBefore(this.newPostItem, this.notesList.firstChild);
        document.querySelector('.note-limit-message').classList.remove('active');
      }).catch(e => {
        console.error(e);
        document.querySelector('.note-limit-message').classList.add('active');
      });
  }

  editNote(e) {
    this.editableNote = e.target.parentNode;

    if (this.editableNote.dataset.state === 'editable') {
      this.editableNote.dataset.state = 'readonly';
      this.makeNoteReadOnly(this.getInnerElements(this.editableNote));
    } else if (this.editableNote.dataset.state === 'readonly') {
      this.editableNote.dataset.state = 'editable';
      this.makeNoteEditable(this.getInnerElements(this.editableNote));
    }
  }

  getInnerElements(note) {
    return {
      note: note,
      editButton: note.querySelector('.edit-note'),
      saveButton: note.querySelector('.update-note'),
      inputTitle: note.querySelector('.note-title-field'),
      textarea: note.querySelector('.note-body-field')
    }
  }

  makeNoteEditable(elements) {
    elements.inputTitle.removeAttribute('readonly');
    elements.textarea.removeAttribute('readonly');
    elements.inputTitle.classList.add('note-active-field')
    elements.textarea.classList.add('note-active-field')
    elements.saveButton.classList.add('update-note--visible');
    elements.editButton.innerHTML = `<i class="fas fa-times" aria-hidden="true"></i> Cancel`;
  }

  makeNoteReadOnly(elements) {
    elements.inputTitle.setAttribute('readonly', 'readonly');
    elements.textarea.setAttribute('readonly', 'readonly');
    elements.inputTitle.classList.remove('note-active-field')
    elements.textarea.classList.remove('note-active-field')
    elements.saveButton.classList.remove('update-note--visible');
    elements.editButton.innerHTML = `<i class="far fa-edit" aria-hidden="true"></i> Edit`;
  }

  init() {
    this.setupDomReferences();
    this.setupEvents();
    console.log(`[myNotes] initialized`);
  }
}

export default MyNotes;