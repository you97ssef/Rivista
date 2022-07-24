import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  credentials = {
    email: '',
    password: '',
  };
  showPassword = false;

  constructor(private authService: AuthService) {}

  ngOnInit(): void {}

  showPasswordToggle() {
    this.showPassword = !this.showPassword;
  }

  login() {
    this.authService.login(this.credentials).subscribe((response: any) => {
      console.log(response);
    });
  }
}
