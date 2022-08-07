import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-rivista-form',
  templateUrl: './rivista-form.component.html',
  styleUrls: ['./rivista-form.component.scss'],
})
export class RivistaFormComponent implements OnInit {
  @Input() rivista: any;
  @Input() categories: any;
  @Input() submit: () => void = (): void => {};

  constructor() {}

  ngOnInit(): void {}

  onSubmit() {
    this.submit();
  }
}
