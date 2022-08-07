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

}
