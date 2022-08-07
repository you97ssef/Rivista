import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-update-profile',
  templateUrl: './update-profile.component.html',
  styleUrls: ['./update-profile.component.scss'],
})
export class UpdateProfileComponent implements OnInit {
  newData: any = {};
  deleteData: any = {};

  constructor(
    private userService: UserService,
    private auth: AuthService,
    private router: Router
  ) {}

  ngOnInit(): void {}

  edit() {
    this.userService.update(this.newData).subscribe((response: any) => {
      this.auth.setUser(response.data);
      this.router.navigate(['/profiles', response.data.slug]);
    });
  }

  delete() {
    this.userService.delete(this.deleteData).subscribe(() => {
      localStorage.clear();
      this.router.navigateByUrl('/');
    });
  }
}
