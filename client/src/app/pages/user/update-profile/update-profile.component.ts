import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { MediaService } from 'src/app/services/media.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-update-profile',
  templateUrl: './update-profile.component.html',
  styleUrls: ['./update-profile.component.scss'],
})
export class UpdateProfileComponent implements OnInit {
  newData: any = {};
  deleteData: any = {};
  image:any = null;

  constructor(
    private userService: UserService,
    private mediaService: MediaService,
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

  selectImage(event: any) {
    this.image = event.target.files[0];
  }

  changeImage() {
    this.mediaService.uploadProfileImage(this.image).subscribe((response: any) => {
      console.log(response);
      this.auth.setUser(response.data);
      this.router.navigate(['/profiles', response.data.slug]);
    });
  }
}
