console.log('scripts.js imported');

document.addEventListener('DOMContentLoaded', () => {
  // Apple-like fade on load
  setTimeout(() => {
    document.querySelectorAll('.opacity-on-load').forEach(el => {
      el.classList.add('fade-in');
    });
  }, 500);

  // Inbox Zero handling
  document.querySelectorAll('.items-paymentplans, .items-creditcards, .items-subscriptions').forEach(container => {
    if (!container.innerHTML.trim()) {
      container.insertAdjacentHTML('beforeend', `
        <div class="inbox-zero">
          <div class="freedom freedom-fireworks">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 128 128"><path d="M8.3 92.3l53.4-24.9-43.8 38.7-9.6-13.8zm106.8-65.1l-46.8 35 55.3-20.4-8.5-14.6zm-107 8.5l52.4 26.9L3 51.7l5.1-16zM125 80.2L68.6 64.6l50 31.2 6.4-15.6zM63.6 2.4l1.5 58.8L47 5.6l16.6-3.2zm16.9 123.7L67.2 69.3 63.8 128l16.7-1.9zm9.8-96.9L66.2 62.4 79.8 24l10.5 5.2zm-43.1 75.6L64 67.7 37.1 98.8l10.1 6zm45.7-4.5l-24.5-33L101 91.9l-8.1 8.4zM33.5 36.5l30.4 27.1-21.6-34.9-8.8 7.8zm-9.7 24.2l1.6 4.9h5.1l-4.2 3 1.6 4.9-4.2-3-4.2 3 1.6-4.9-4.2-3H22l1.8-4.9zm19.3 57.9h-4.8l3.9 2.8-1.5 4.5 3.9-2.8 3.9 2.8-1.5-4.5 3.9-2.8h-4.8l-1.5-4.5-1.5 4.5zm54.6-10h-4.5l3.6 2.6-1.4 4.3 3.6-2.6 3.6 2.6-1.4-4.3 3.6-2.6h-4.5l-1.4-4.3-1.2 4.3zm14.2-50h-5l4 2.9-1.5 4.7 4-2.9 4 2.9-1.5-4.7 4-2.9h-5l-1.5-4.7-1.5 4.7zM86.3 6.9h-6.9L85 11l-2.1 6.6 5.6-4.1 5.6 4.1L92 11l5.6-4.1h-6.9L88.6.3l-2.3 6.6zM18.9 8.1h-8.5l6.9 5-2.6 8.1 6.9-5 6.9 5-2.8-8.2 6.9-5h-8.5l-2.6-8-2.6 8.1z" fill="#141414"></path></svg>
            <p class="punchline">All done!<br>Keep it that way!</p>
          </div>
        </div>
      `);
    }
  });

  // Input handling
  const handleSpaces = (input) => {
    input.value = input.value.replace(/ +?/g, '');
  };

  const handleCommas = (input) => {
    input.value = input.value.replace(',', '.');
  };

  ['refnumber', 'accountnumber', 'billnumber', 'amount'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('keyup', () => handleSpaces(element));
      element.addEventListener('focus', () => handleSpaces(element));
    }
  });

  document.querySelectorAll('#amount, .amount-big').forEach(element => {
    element.addEventListener('keyup', () => handleCommas(element));
  });

  // Copy to clipboard functionality
  document.querySelectorAll('.able-to-copy').forEach(element => {
    element.addEventListener('click', function() {
      const value = this.getAttribute('data-copy-to-clipboard');
      const temp = document.createElement('input');
      document.body.appendChild(temp);
      temp.value = value;
      temp.select();
      document.execCommand('copy');
      temp.remove();

      const message = document.createElement('div');
      message.className = 'message success';
      message.textContent = 'Tallessa!';
      this.appendChild(message);

      setTimeout(() => message.remove(), 2000);
    });
  });

  // Add click handlers for new bill button
  document.querySelectorAll('.add-new-bill').forEach(btn => {
    btn.addEventListener('click', () => {
      document.body.classList.add('modal-opened');
      const modal = document.querySelector('.modal-bill-new');
      document.body.appendChild(modal);
      modal.style.display = 'flex';
      modal.classList.add('show');
      document.querySelector('.bill-title').textContent = 'Uusi lasku';
    });
  });

  document.querySelectorAll('.bills-list .row-clickable').forEach(row => {
    row.addEventListener('click', function() {
      const rowId = this.getAttribute('data-row-id');
      document.body.classList.add('modal-opened');
      const modal = document.querySelector(`.modal-bill-${rowId}`);
      document.body.appendChild(modal);
      modal.style.display = 'flex';
      modal.classList.add('show');
    });
  });

  // Close modal handlers
  document.addEventListener('keyup', (e) => {
    if (e.key === 'Escape') {
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal-bill, .modal').forEach(modal => {
        modal.classList.remove('show');
      });
    }
  });

  document.addEventListener('click', (e) => {
    if (e.target.matches('.show .modal-overlay')) {
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal-bill, .modal').forEach(modal => {
        modal.classList.remove('show');
      });
    }
  });

  // Date and amount formatting
  const formatDates = () => {
    document.querySelectorAll('.formatted-duedate').forEach(element => {
      const formattedDate = element.textContent;
      const now = Date.now();
      const d = moment(formattedDate, "YYYY-MM-DD H:i:s");
      element.innerHTML = d.fromNow();
      element.classList.add(d > now ? 'future' : 'past');
    });
  };

  const colorAmounts = (selector, ranges) => {
    document.querySelectorAll(selector).forEach(element => {
      const formattedAmount = parseInt(element.textContent);
      const amount = element.closest('.amount');

      ranges.forEach(({min, max, className}) => {
        if ((!max && formattedAmount >= min) ||
            (formattedAmount >= min && formattedAmount <= max)) {
          element.classList.add(className);
          if (amount) amount.classList.add(className);
        }
      });
    });
  };

  // Initialize formatting
  formatDates();
  colorAmounts('.formatted-amount', [
    { min: 0, max: 30, className: 'color-low' },
    { min: 30, max: 40, className: 'color-medium' },
    { min: 40, className: 'color-high' }
  ]);
  colorAmounts('.formatted-amount-high', [
    { min: 0, max: 80, className: 'color-low' },
    { min: 80, max: 150, className: 'color-medium' },
    { min: 150, className: 'color-high' }
  ]);
});
