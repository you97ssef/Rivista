import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-rivista-card',
  templateUrl: './rivista-card.component.html',
  styleUrls: ['./rivista-card.component.scss']
})
export class RivistaCardComponent implements OnInit {
  @Input() rivista: any;

  constructor() { }

  ngOnInit(): void {
  }

  format(content: string) {
    const tmp = document.createElement('DIV');
    tmp.innerHTML = content;
    return tmp.textContent || tmp.innerText || '';
  }
}
