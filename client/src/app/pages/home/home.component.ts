import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
})
export class HomeComponent implements OnInit {
  constructor() {}

  ngOnInit(): void {}

  isVerified() {
    let user = localStorage.getItem('user');

    if (!user) return true; 

    if (JSON.parse(user).email_verified_at) return true;

    return false;
  }
}
