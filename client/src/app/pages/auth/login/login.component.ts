import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  showPassword = false;

  constructor() {}

  ngOnInit(): void {}

  showPasswordToggle() {
    this.showPassword = !this.showPassword;
  }

  login() {
    console.log('login');
  }
}
