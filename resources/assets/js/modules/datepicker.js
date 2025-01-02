class VanillaDatePicker {
  constructor(element, options = {}) {
    this.element = element;
    this.options = {
      format: 'DD.MM.YYYY',
      lang: document.documentElement.lang || 'en',
      weekStart: 1,
      ...options
    };

    // Ensure moment is available
    if (typeof moment === 'undefined') {
      throw new Error('Moment.js is required for the datepicker');
    }

    this.init();
  }

  init() {
    this.element.addEventListener('click', () => this.show());
    document.addEventListener('click', (e) => {
      if (!this.element.contains(e.target) && this.picker && !this.picker.contains(e.target)) {
        this.hide();
      }
    });

    this.createPicker();
  }

  createPicker() {
    const currentDate = moment();
    const template = `
      <div class="dtp hidden">
        <div class="dtp-content">
          <div class="dtp-date-view">
            <header class="dtp-header">
              <div class="dtp-actual-day">${currentDate.format('dddd')}</div>
              <div class="dtp-close"><button type="button">&times;</button></div>
            </header>
            <div class="dtp-date">
              <div class="dtp-actual-month">${currentDate.format('MMM')}</div>
              <div class="dtp-actual-num">${currentDate.format('DD')}</div>
              <div class="dtp-actual-year">${currentDate.format('YYYY')}</div>
            </div>
            <div class="dtp-picker">
              <div class="dtp-picker-calendar"></div>
            </div>
          </div>
        </div>
      </div>`;

    this.picker = document.createElement('div');
    this.picker.innerHTML = template;
    document.body.appendChild(this.picker.firstElementChild);
    this.picker = document.body.lastElementChild;

    this.picker.querySelector('.dtp-close button').addEventListener('click', () => this.hide());
    this.setupCalendarControls();
  }

  setupCalendarControls() {
    const calendar = this.picker.querySelector('.dtp-picker-calendar');
    this.renderCalendar(calendar);

    // Add month/year navigation
    this.picker.querySelector('.dtp-actual-month').addEventListener('click', () => this.showMonthPicker());
    this.picker.querySelector('.dtp-actual-year').addEventListener('click', () => this.showYearPicker());
  }

  renderCalendar(container) {
    const currentDate = moment();
    const startOfMonth = currentDate.clone().startOf('month');
    const endOfMonth = currentDate.clone().endOf('month');

    // Generate calendar HTML
    let html = '<table class="dtp-picker-days"><thead><tr>';

    // Add weekday headers
    moment.weekdaysMin().forEach(day => {
      html += `<th>${day}</th>`;
    });

    html += '</tr></thead><tbody>';

    // Add calendar days
    let week = [];
    let firstDay = startOfMonth.day();

    // Fill in empty days at start
    for (let i = 0; i < firstDay; i++) {
      week.push('<td></td>');
    }

    // Add actual days
    for (let day = 1; day <= endOfMonth.date(); day++) {
      week.push(`<td class="dtp-picker-day" data-date="${day}">${day}</td>`);

      if (week.length === 7) {
        html += '<tr>' + week.join('') + '</tr>';
        week = [];
      }
    }

    // Fill in empty days at end
    if (week.length > 0) {
      while (week.length < 7) {
        week.push('<td></td>');
      }
      html += '<tr>' + week.join('') + '</tr>';
    }

    html += '</tbody></table>';
    container.innerHTML = html;

    // Add click handlers for days
    container.querySelectorAll('.dtp-picker-day').forEach(day => {
      day.addEventListener('click', () => this.selectDate(day.dataset.date));
    });
  }

  selectDate(day) {
    const date = moment().date(day);
    this.element.value = date.format(this.options.format);
    this.hide();
  }

  show() {
    this.picker.classList.remove('hidden');
  }

  hide() {
    this.picker.classList.add('hidden');
  }
}

// Initialize datepickers
if (typeof moment !== 'undefined') {
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.datepicker').forEach(el => {
      new VanillaDatePicker(el);
    });
  });
}
