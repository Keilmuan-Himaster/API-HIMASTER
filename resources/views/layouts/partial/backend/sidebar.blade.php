<div class="left side-menu">
   <div class="sidebar-inner slimscrollleft">

       <!-- User -->

       <!-- End User -->

       <!--- Sidemenu -->
       <div id="sidebar-menu">
           <ul>
               <li class="text-muted menu-title">Navigation</li>

               <li>
                   <a href="{{ route('backend.home') }}" class="waves-effect"><i class="mdi mdi-view-dashboard"></i>
                       <span> Dashboard </span> </a>
               </li>
               <li class="has_sub">
                   <a href="javascript:void(0);" class="waves-effect "><i class="mdi mdi-invert-colors"></i> <span>
                           Posts</span> <span class="menu-arrow"></span></a>
                   <ul class="list-unstyled">
                       <li><a href="{{ route('backend.post.content.index') }}">Content</a></li>
                       <li><a href="{{ route('backend.post.tag.index') }}">Tags</a></li>
                       <li><a href="{{ route('backend.post.category.index') }}">Categories</a></li>
                       <li><a href="{{ route('backend.post.gallery.index') }}">Gallery</a></li>
                       <li><a href="{{ route('backend.post.buster.index') }}">Buster</a></li>
                       {{-- <li><a href="form-wizard.html">Galeries</a></li> --}}

                   </ul>
               </li>
               <li>
                   <a href="{{ route('backend.slider.index') }}" class="waves-effect"><i
                           class="mdi mdi-invert-colors"></i> <span>Slider</span></span></a>
               </li>
               <li>
                   <a href="{{ route('backend.timeline.index') }}" class="waves-effect"><i
                           class="mdi mdi-invert-colors"></i> <span>Timeline</span></span></a>
               </li>

               <li class="has_sub">
                   <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-invert-colors"></i>
                       <span>Tentang HIMASTER</span></a>
                   <ul class="list-unstyled">
                       <li><a href="{{ route('backend.about.member.index') }}">Anggota</a></li>
                       <li><a href="{{ route('backend.about.structure.index') }}">Komponen</a></li>
                       <li><a href="{{ route('backend.about.contact.index') }}">Kontak</a></li>
                   </ul>
               </li>

               <li>

                   <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                       <i class="fa fa-sign-out"></i><span> Logout </span>
                   </a>


                   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                       @csrf
                   </form>
               </li>

               {{-- <li class="has_sub">
              <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-texture"></i><span class="badge badge-warning pull-right">7</span><span> Forms </span> </a>
              <ul class="list-unstyled">
                 <li><a href="form-elements.html">Articles</a></li>
                 <li><a href="form-advanced.html">Categories</a></li>
                 <li><a href="form-validation.html">Tags</a></li>
                 <li><a href="form-wizard.html">Galeries</a></li>
              </ul>
           </li> --}}



           </ul>
           <div class="clearfix"></div>
       </div>
       <!-- Sidebar -->
       <div class="clearfix"></div>

   </div>

</div><!-- end navbar-custom -->
