document.addEventListener('DOMContentLoaded', () => {
  // Open new modal from click
  document.addEventListener('click', (e) => {
    if (e.target.matches('.add-new-credit-card')) {
      document.body.classList.add('modal-opened');
      const modal = document.querySelector('.modal-credit-card-new');
      document.body.appendChild(modal);
      modal.style.display = 'none';
      setTimeout(() => {
        modal.style.display = 'block';
        modal.classList.add('show');
      }, 10);
    }
  });

  // Open modal when clicking single items
  const itemsContainer = document.querySelector('.items-creditcards');
  if (itemsContainer) {
    itemsContainer.addEventListener('click', (e) => {
      if (e.target.matches('.item') || e.target.closest('.item')) {
        const item = e.target.matches('.item') ? e.target : e.target.closest('.item');
        const rowId = item.dataset.id;
        document.body.classList.add('modal-opened');
        const modal = document.querySelector(`.modal-credit-card-${rowId}`);
        document.body.appendChild(modal);
        modal.style.display = 'none';
        setTimeout(() => {
          modal.style.display = 'block';
          modal.classList.add('show');
        }, 10);
      }
    });
  }

  // Save credit card to database
  document.addEventListener('click', (e) => {
    if (e.target.matches('#submit-credit-card')) {
      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      const modal = document.querySelector('.modal-credit-card-new');
      const data = {
        save: 1,
        creditor: modal.querySelector('#creditor').value,
        expirationdate: modal.querySelector('#expirationdate').value,
        lastfourdigits: modal.querySelector('#lastfourdigits').value,
        monthlyamount: modal.querySelector('#monthlycut').value,
        creditcard_amount_paid: modal.querySelector('#creditcard_amount_paid').value,
        creditcard_amount_total: modal.querySelector('#creditcard_amount_total').value
      };

      fetch('addcreditcard', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
      .then(response => response.text())
      .then(html => {
        const lastItem = document.querySelector('.items-credit-cards > .item:last-child');
        lastItem.insertAdjacentHTML('afterend', html);
        location.reload();
      });
    }
  });

  // Edit credit card
  document.addEventListener('click', (e) => {
    if (e.target.matches('#update-credit-card')) {
      const editId = e.target.dataset.id;
      const modal = document.querySelector(`.modal-credit-card-${editId}`);

      const data = {
        update: 1,
        id: editId,
        creditor: modal.querySelector('#creditor').value,
        expirationdate: modal.querySelector('#expirationdate').value,
        lastfourdigits: modal.querySelector('#lastfourdigits').value,
        monthlyamount: modal.querySelector('#monthlycut').value,
        creditcard_amount_paid: modal.querySelector('#creditcard_amount_paid').value,
        creditcard_amount_total: modal.querySelector('#creditcard_amount_total').value
      };

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      fetch('editcreditcard', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
      .then(response => response.text())
      .then(html => {
        document.querySelector(`.item-${editId}`).outerHTML = html;
      });
    }
  });

  // Remove credit card
  document.addEventListener('click', (e) => {
    if (e.target.matches('#remove-credit-card')) {
      const editId = e.target.dataset.id;

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      // Fade out
      const item = document.querySelector(`.item-${editId}`);
      item.style.transition = 'opacity 0.3s';
      item.style.opacity = '0';
      setTimeout(() => item.style.display = 'none', 300);

      fetch('removecreditcard', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id: editId })
      });
    }
  });
});
